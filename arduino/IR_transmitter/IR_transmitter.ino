#include <IRremote.h>
IRsend irsend(2);

static unsigned long last_interval_ms = 0;
void setup() {
 
  Serial.begin(115200);
}

void loop() {
  
  
    if(millis()>last_interval_ms+200){
      last_interval_ms=millis();
      irsend.sendNEC(0x100,HEX);//0x100 could be changed
    }
}
