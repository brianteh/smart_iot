#include <WiFi.h>
#include <ArduinoJson.h>
#include <HTTPClient.h>
#include <WebSocketsClient.h>

#include <SPIFFS.h>

#include <Arduino.h>
#include <IRremoteESP8266.h>
#include <IRrecv.h>
#include <IRutils.h>

#include <Nursing_Guardian_inferencing.h>
#include <Adafruit_MPU6050.h>
#include <Adafruit_Sensor.h>
#include <Wire.h>

#include "MAX30105.h"
#include "heartRate.h"


#include <Keypad.h>

/*---------------------START OF KEYPAD SETTINGS---------------------------*/
const byte ROWS = 4;
const byte COLS = 4;
char keys[ROWS][COLS] = {
  {'1','2','3','A'},
  {'4','5','6','B'},
  {'7','8','9','C'},
  {'*','0','#','D'}
};
byte rowPins[ROWS] = {27,14,12,13};
byte colPins[COLS] = {26,25,33,32};
//Create an object of keypad
Keypad keypad = Keypad( makeKeymap(keys), rowPins, colPins, ROWS, COLS );
/*---------------------END OF KEYPAD SETTINGS---------------------------*/

/*---------------------START OF WS & WF SETTINGS---------------------------*/
String server_ip;
String auth_id;
int server_port;
JsonArray location_ids;
WebSocketsClient ws_client;
/*---------------------END OF WS & WF SETTINGS----------------------*/


/*-------------------START OF IR RECEIVER SETTINGS-------------------------*/
// An IR detector/demodulator is connected to GPIO pin 14(D5 on a NodeMCU
// board).
// Note: GPIO 16 won't work on the ESP8266 as it does not have interrupts.
// Note: GPIO 14 won't work on the ESP32-C3 as it causes the board to reboot.
#ifdef ARDUINO_ESP32C3_DEV
const uint16_t recv_pin = 10;  // 14 on a ESP32-C3 causes a boot loop.
#else  // ARDUINO_ESP32C3_DEV
const uint16_t recv_pin = 2;
#endif  // ARDUINO_ESP32C3_DEV

IRrecv irrecv(recv_pin);
decode_results results;
/*-------------------END OF IR RECEIVER SETTINGS---------------------*/


/*--------------------START OF MPU6050 SETTINGS---------------------------------------*/
Adafruit_MPU6050 mpu;

float features[EI_CLASSIFIER_DSP_INPUT_FRAME_SIZE];
size_t feature_ix = 0;

static unsigned long last_interval_ms = 0;

/*-------------------END OF MPU6050 SETTINGS---------------------------------------*/

/*--------------------START OF MAX30102 SETTINGS------------------------*/
MAX30105 particleSensor;

const byte RATE_SIZE = 4; //Increase this for more averaging. 4 is good.
byte rates[RATE_SIZE]; //Array of heart rates
byte rateSpot = 0;
long lastBeat = 0; //Time at which the last beat occurred

float beatsPerMinute;
int beatAvg;
int threshold_hr = 200;
/*--------------------END OF MAX30102 SETTINGS-------------------------*/

/*-------------------TASK ON CORE 0-----------------------*/
TaskHandle_t subtask; // for running on core 0 for other sensors
/*--------------------------------------------------------------------*/

/*--------------------------STATE VARIABLES--------------------------*/
bool observer = false;
#define FREQUENCY_HZ        60
#define INTERVAL_MS         (1000 / (FREQUENCY_HZ + 1))
#define location_update_interval_ms 200
#define health_update_interval_ms 100
#define heart_rate_sensor_interval_ms 20
String location_id = "XXX";
int hr_arr[]={73,82,93,74,76,84,83,92,85,72};
int counter=0;
/*--------------------------------------------------------------------*/

void setup() {
  Serial.begin(115200);  // init serial port for debugging

  
 
  IR_init();//pin 14
  MPU6050_init();//pin 21,22 : SDA,SCL
  //MAX30102_init(); //pin 4,5 : SDA,SCL
  
  // Access SPIFFS
  if (!SPIFFS.begin()) {
    Serial.println("SPIFFS could not initialize");
  }

  // Open the JSON file
  File file = SPIFFS.open("/config.json", "r");
  if (!file) {
    Serial.println("Failed to open file");
    return;
  }

  // Read the JSON data from the file
  size_t size = file.size();
  std::unique_ptr<char[]> buf(new char[size]);
  file.readBytes(buf.get(), size);
  file.close();

  // Parse the JSON data
  StaticJsonDocument<300> doc; // Adjust the buffer size as needed
  DeserializationError error = deserializeJson(doc, buf.get());

  if (error) {
    Serial.println("Failed to parse JSON");
    return;
  }

  // Access JSON data
  server_ip = String((const char*)doc["server_ip"]);
  server_port = String((const char*)doc["server_port"]).toInt();
  auth_id = String((const char*)doc["auth_id"]);
  location_ids =  doc["location_ids"].as<JsonArray>();
  const char* wifi_ssid = doc["ssid"];
  const char* wifi_password = doc["pass"];
  WIFI_init(wifi_ssid,wifi_password);

  Serial.println(server_ip);
  Serial.println(server_port);
  Serial.println(auth_id);

  ws_client.begin(server_ip,server_port,"/");
  ws_client.onEvent(webSocketEvent);
 

  xTaskCreatePinnedToCore(
    loop_sensors,
    "subtask",
    1000,
    NULL,
    0,
    &subtask,
    0);

  update_false_alarm();
  
}

void loop() {
  ws_client.loop();
  char key = keypad.getKey();
  
  if (ws_client.isConnected()) {
    heart_rate_sensor();
  }
  MPU6050_sensor(0.8);
  //IR_sensor();
  if(key=='1'){
    update_panic(1);
  }
  if(key=='2'){
    update_panic(2);
  }
  if(key=='3'){
    update_panic(3);
  }
  if(key=='4'){
    update_panic(4);
  }
  if(key=='5'){
    update_panic(5);
  }
  if(key=='*'){
    update_false_alarm();
  }
  
  
  
}

void MPU6050_init(){
  if(!mpu.begin()) {
    Serial.println("Failed to find MPU6050 chip");
    while (1) {
      delay(10);
    }
  }
  Serial.println("MPU6050 Found!");

  mpu.setAccelerometerRange(MPU6050_RANGE_8_G);
  mpu.setGyroRange(MPU6050_RANGE_500_DEG);
  mpu.setFilterBandwidth(MPU6050_BAND_21_HZ);
}

void WIFI_init(const char* wifi_ssid,const char* wifi_password){
  //Connect to Router
  WiFi.begin(wifi_ssid, wifi_password);
 
  while (WiFi.status() != WL_CONNECTED) {
    delay(1000);
    Serial.print(".");
  }
  Serial.println();
  Serial.print("Established connection with :");
  Serial.println(wifi_ssid);
  Serial.println();
  Serial.print("Connected to network with IP address: ");
  Serial.println(WiFi.localIP()); 
}

void IR_init(){
  irrecv.enableIRIn();  // Start the receiver
  while (!Serial)  // Wait for the serial connection to be establised.
    delay(50);
  Serial.println();
  Serial.print("IRrecvDemo is now running and waiting for IR message on Pin ");
  Serial.println(recv_pin);
}

void MAX30102_init(){
  Wire.begin(4,5);
  // Initialize sensor
  if (!particleSensor.begin(Wire, MAX30105_ADDRESS)) {
    Serial.println("MAX30102 was not found. Please check wiring/power. ");
    while (1);
  }
  Serial.println("Place your index finger on the sensor with steady pressure.");

  particleSensor.setup(); //Configure sensor with default settings
  particleSensor.setPulseAmplitudeRed(0x0A); //Turn Red LED to low to indicate sensor is running
  particleSensor.setPulseAmplitudeGreen(0); //Turn off Green LED
}


void webSocketEvent(WStype_t type, uint8_t * payload, size_t length) {
  if (type == WStype_DISCONNECTED) {
    Serial.println("WebSocket disconnected");
  } else if (type == WStype_CONNECTED) {
    Serial.println("WebSocket connected");
    StaticJsonDocument<200> buff;
    buff["auth_id"] = auth_id;
    buff["client_type"] = 2;
    String output_string;
    serializeJson(buff,output_string);
    ws_client.sendTXT(output_string); 
  } else if (type == WStype_TEXT) {
    int observer_num = String((char*)payload).toInt();
    if(observer_num>0){
      observer = true;  
    }else if(observer_num == 0){
      observer = false;  
    }
  }
}
