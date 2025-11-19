// https://wokwi.com/projects/438282694716998657

#include <WiFi.h>
#include <HTTPClient.h>
#include <LiquidCrystal_I2C.h>
#include <ESP32Servo.h>

const char* ssid = "Wokwi-GUEST";
const char* password = "";

const char* serverUrl = "https://doctor.uzay.info/sendesp32.php";
const char* confirmationCode = "12345678910";

int lcdColumns = 16;
int lcdRows = 2;
LiquidCrystal_I2C lcd(0x27, lcdColumns, lcdRows);

Servo servos[4];
const int servoPins[4] = {32, 33, 34, 35};

String lastData = "";

void setup() {
  Serial.begin(115200);
  lcd.init();
  lcd.backlight();
  for (int i = 0; i < 4; i++) {
    servos[i].attach(servoPins[i], 1000, 2000);
    servos[i].write(90);
  }
  WiFi.begin(ssid, password);
  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
  }
}

void loop() {
  while (true) {
    if (WiFi.status() == WL_CONNECTED) {
      HTTPClient http;
      String url = String(serverUrl) + "?confirmation_code=" + confirmationCode;
      http.begin(url);
      int httpCode = http.GET();
      if (httpCode == HTTP_CODE_OK) {
        String payload = http.getString();
        if (payload != lastData) {
          lastData = payload;
          parseData(payload);
        }
      }
      http.end();
    }
    delay(60000);
  }
}

void parseData(String data) {
  int start = 0;
  int end = data.indexOf(';', start);
  while (end != -1) {
    String record = data.substring(start, end);
    printRecord(record);
    start = end + 1;
    end = data.indexOf(';', start);
  }
  String lastRecord = data.substring(start);
  if (lastRecord.length() > 0) {
    printRecord(lastRecord);
  }
}

void printRecord(String record) {
  String fields[6];
  int start = 0;
  int end = -1;
  for (int i = 0; i < 6; i++) {
    end = record.indexOf(',', start);
    if (end == -1 && i < 5) {
      fields[i] = record.substring(start);
      for (int j = i + 1; j < 6; j++) fields[j] = "";
      break;
    } else if (end == -1 && i == 5) {
      fields[i] = record.substring(start);
    } else {
      fields[i] = record.substring(start, end);
      start = end + 1;
    }
  }

  Serial.println("Kayıt:");
  Serial.print("Ad: "); Serial.println(fields[0]);
  Serial.print("Soyad: "); Serial.println(fields[1]);
  Serial.print("İlaç: "); Serial.println(fields[2]);
  Serial.print("Doz: "); Serial.println(fields[3]);
  Serial.print("Günlük Miktar: "); Serial.println(fields[4]);
  Serial.print("Numara: "); Serial.println(fields[5]);
  Serial.println();

  lcd.clear();
  lcd.setCursor(0, 0);
  lcd.print(fields[0]);
  lcd.setCursor(0, 1);
  lcd.print(fields[1]);
  delay(3000);

  int len = fields[2].length();
  if (fields[4] == "max6") fields[4] = "6≥";

  lcd.clear();
  lcd.setCursor(0, 0);
  lcd.print("Medicine Name:");
  lcd.setCursor(0, 1);
  lcd.print(fields[2].substring(0, len - 2));
  delay(5000);

  lcd.clear();
  lcd.setCursor(0, 0);
  lcd.print("Dose: " + fields[3] + fields[2].substring(len - 2));
  lcd.setCursor(13, 0);
  lcd.print("NO" + fields[5]);
  lcd.setCursor(0, 1);
  lcd.print("Daily Amount: " + fields[4]);

  int servoNum = fields[5].toInt();
  servos[servoNum - 1].write(180);
  delay(978); // for v5.0
  servos[servoNum - 1].write(90);
  delay(5044);
  servos[servoNum - 1].write(180);
  delay(978); // for v5.0
  servos[servoNum - 1].write(90);
  lcd.clear();
}