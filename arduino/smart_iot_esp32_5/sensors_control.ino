void loop_sensors(void * parameter){
  for(;;){
    IR_sensor();
  }
}
void IR_sensor(){
  if (irrecv.decode(&results)) {
    // print() & println() can't handle printing long longs. (uint64_t)
    serialPrintUint64(results.value, HEX);
    location_id = String(results.value,HEX);
    Serial.println("");
    irrecv.resume();  // Receive the next value
  }
  if (millis() > last_interval_ms + location_update_interval_ms) {
    last_interval_ms = millis();
    for (JsonVariant id : location_ids) {
      if (id == location_id) {
        update_location(); 
        break; // Value found, no need to continue searching
      }
    }
  }
}

void MPU6050_sensor(double confidence){
  sensors_event_t a, g, temp;

  if (millis() > last_interval_ms + INTERVAL_MS) {
    last_interval_ms = millis();
    mpu.getEvent(&a, &g, &temp);

    features[feature_ix++] = a.acceleration.x;
    features[feature_ix++] = a.acceleration.y;
    features[feature_ix++] = a.acceleration.z;
    features[feature_ix++] = a.gyro.x;
    features[feature_ix++] = a.gyro.y;
    features[feature_ix++] = a.gyro.z;

    if (feature_ix == EI_CLASSIFIER_DSP_INPUT_FRAME_SIZE) {
      
      signal_t signal;
      ei_impulse_result_t result;
      int err = numpy::signal_from_buffer(features, EI_CLASSIFIER_DSP_INPUT_FRAME_SIZE, &signal);
      if (err != 0) {
        ei_printf("Failed to create signal from buffer (%d)\n", err);
        return;
      }

      EI_IMPULSE_ERROR res = run_classifier(&signal, &result, true);

      if (res != 0) return;


      for (size_t ix = 0; ix < EI_CLASSIFIER_LABEL_COUNT; ix++) {
        ei_printf("%s : %.5f\n", result.classification[ix].label, result.classification[ix].value);
        if (result.classification[ix].value > confidence) {
          if (result.classification[ix].label == "falling")
          {
            update_fall();
          } else if (result.classification[ix].label == "random movement")
          {
              
          }else if(result.classification[ix].label == "walking"){
            update_walking();
            
          }
        }
      }
      feature_ix = 0;
    }

  }
}

void heart_rate_sensor(){
  long ir_val= particleSensor.getIR();

  if (checkForBeat(ir_val) == true) {
    //We sensed a beat!
    long delta = millis() - lastBeat;
    lastBeat = millis();

    beatsPerMinute = 60 / (delta / 1000.0);

    if (beatsPerMinute < 255 && beatsPerMinute > 20) {
      rates[rateSpot++] = (byte)beatsPerMinute; //Store this reading in the array
      rateSpot %= RATE_SIZE; //Wrap variable

      //Take average of readings
      beatAvg = 0;
      for (byte x = 0 ; x < RATE_SIZE ; x++)
        beatAvg += rates[x];
      beatAvg /= RATE_SIZE;
    }
  }
  if (millis() > last_interval_ms + heart_rate_sensor_interval_ms) {
    last_interval_ms = millis();
    if(observer){
      StaticJsonDocument<200> buff;
      buff["auth_id"] = auth_id;
      buff["client_type"] = 2;
      buff["hr"] = beatAvg;
      buff["ir"]= ir_val;
      
      String output_string;
      serializeJson(buff,output_string);
      ws_client.sendTXT(output_string);
    }
  }
  if(beatAvg > threshold_hr){
    if (millis() > last_interval_ms + health_update_interval_ms) {
      last_interval_ms = millis();
      update_health();
    }
  }
  
}


void ei_printf(const char *format, ...) {
  static char print_buf[1024] = { 0 };

  va_list args;
  va_start(args, format);
  int r = vsnprintf(print_buf, sizeof(print_buf), format, args);
  va_end(args);

  if (r > 0) {
    Serial.write(print_buf);
  }
}
