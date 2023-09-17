void update_fall(){
  
  HTTPClient http;
  String response;
  
  StaticJsonDocument<200> buff;
  String json_param;

  
  buff["auth_id"] = auth_id;
  buff["location_id"] = location_id;
  

  serializeJson(buff,json_param);

  //Serial.println(json_param);
  
  http.begin("http://"+server_ip+"/smart_iot/fall_detect/index.php");
  http.POST(json_param);
  response = http.getString();
  Serial.println(response);
  
  
}

void update_health(){
  
  HTTPClient http;
  String response;
  
  StaticJsonDocument<200> buff;
  String json_param;

  
  buff["auth_id"] = auth_id;
  buff["hr"] = beatAvg;
  buff["location_id"] = location_id;
  

  serializeJson(buff,json_param);

  //Serial.println(json_param);
  
  http.begin("http://"+server_ip+"/smart_iot/health_status/index.php");
  http.POST(json_param);
  response = http.getString();
  Serial.println(response);
  
  
}

void update_location(){
  
  HTTPClient http;
  String response;
  
  StaticJsonDocument<200> buff;
  String json_param;

  
  
  buff["auth_id"] = auth_id;
  buff["location_id"] = location_id;
  

  serializeJson(buff,json_param);

  //Serial.println(json_param);
  
  http.begin("http://"+server_ip+"/smart_iot/location/index.php");
  http.POST(json_param);
  response = http.getString();
  Serial.println(response);
}

void update_panic(int panic_id){
  HTTPClient http;
  String response;
  
  StaticJsonDocument<200> buff;
  String json_param;

  
  
  buff["auth_id"] = auth_id;
  buff["location_id"] = location_id;
  buff["panic_id"] = panic_id;
  

  serializeJson(buff,json_param);

  //Serial.println(json_param);
  
  http.begin("http://"+server_ip+"/smart_iot/misc_function/index.php");
  http.POST(json_param);
  response = http.getString();
  Serial.println(response);
}


void update_false_alarm(){
  HTTPClient http;
  String response;
  
  StaticJsonDocument<200> buff;
  String json_param;

  
  
  buff["auth_id"] = auth_id;
  buff["location_id"] = location_id;
  

  serializeJson(buff,json_param);

  //Serial.println(json_param);
  
  http.begin("http://"+server_ip+"/smart_iot/false_alarm/index.php");
  http.POST(json_param);
  response = http.getString();
  Serial.println(response);
}

void update_walking(){
  HTTPClient http;
  String response;
  
  StaticJsonDocument<200> buff;
  String json_param;

  
  
  buff["auth_id"] = auth_id;
  

  serializeJson(buff,json_param);

  //Serial.println(json_param);
  
  http.begin("http://"+server_ip+"/smart_iot/walk_status/index.php");
  http.POST(json_param);
  response = http.getString();
  Serial.println(response);
  
}
