#include <Servo.h>

Servo servos[4];

const int servoPins[4] = {3, 5, 6, 9};
const int JOYSTICK_X = A0;
const int JOYSTICK_Y = A1;
const int JOYSTICK_BUTTON = 7;

const int DEADZONE_LOW = 384;
const int DEADZONE_HIGH = 640;

bool servoActive = false;
int activeServo = 0;

void setup() {
  for (int i = 0; i < 4; i++) {
    servos[i].attach(servoPins[i], 1000, 2000);
    servos[i].write(90);
  }
  pinMode(JOYSTICK_BUTTON, INPUT_PULLUP);
}

void loop() {
  int x = analogRead(JOYSTICK_Y);
  int y = analogRead(JOYSTICK_X);
  bool buttonPressed = digitalRead(JOYSTICK_BUTTON) == LOW;

  if (!servoActive) {
    if (y > DEADZONE_HIGH) {
      delay(2000);
      servos[0].write(0);
      activeServo = 1;
      servoActive = true;
    } else if (x > DEADZONE_HIGH) {
      delay(2000);
      servos[1].write(0);
      activeServo = 2;
      servoActive = true;
    } else if (y < DEADZONE_LOW) {
      delay(2000);
      servos[2].write(180);
      activeServo = 3;
      servoActive = true;
    } else if (x < DEADZONE_LOW) {
      delay(2000);
      servos[3].write(0);
      activeServo = 4;
      servoActive = true;
    }
  }

  if (servoActive) {
    if (buttonPressed) {
      switch (activeServo) {
        case 1: servos[0].write(90); break;
        case 2: servos[1].write(90); break;
        case 3: servos[2].write(90); break;
        case 4: servos[3].write(90); break;
      }
      servoActive = false;
      activeServo = 0;
    }
  }
}
