# **3D** <img src="https://github.com/user-attachments/assets/dbb129f0-201a-4ce0-82e2-1f72f849cdb2" alt="doctor" width="32"> **Web Doctor** 

The system language is Turkish. You can <strong>contribute</strong> to us in other languages!

You can review our project at <strong>[doctor.uzay.info](https://doctor.uzay.info/)!</strong>

<strong>Warning:</strong> This project was developed to provide safe and understandable dosage recommendations for non-prescription (over-the-counter) medications for common health complaints (e.g., fever, headache, stomachache, etc.). <strong>This information is for informational purposes only</strong>, please consult a healthcare provider <strong>if necessary</strong>.


## How to use?
To use our project, you must first log in as a user and enter your pharmacy information. 

(The information you enter does not have to be real; you can use it for testing purposes only:))

When you open the home page, a login form will appear asking for your login information.

<strong>Warning:</strong> Please ensure you enter your sensitive information correctly. Sensitive information is stored in a specially encrypted format, and even if you enter the same information multiple times, the encryption algorithm will store it differently each time. You may intentionally enter your sensitive information incorrectly into our system, but if you cannot recall it (since not even the system owner has access to this information), you may not be able to log in to your account again.

## Login Form

<img width="400" height="400" alt="loginform" src="https://github.com/user-attachments/assets/07a2ed19-4329-45de-aabe-3117f3ce2a7d" />

If you are not registered, you can register to the system by clicking the Register button.

## Register Form

<img width="400" height="600" alt="registerform" src="https://github.com/user-attachments/assets/2bb0920d-c273-4ccc-aa29-a796c561d496" />

You must register with your pharmacy for additional transactions. Pharmacy registration is not required for use solely for obtaining 3D Web Doctor recommendations.

## Pharmacy Registration Form

<img width="1000" height="450" alt="pharmacyregister" src="https://github.com/user-attachments/assets/60610679-2b8a-4d88-ac36-7d0f5cf8f4be" />

You can specify the order of medications you want to see in your medicine cabinet by dragging them during the pharmacy registration process.

<img width="300" height="150" alt="medicineorder" src="https://github.com/user-attachments/assets/de1a26e1-41fd-4b24-8f48-3791022bac92" />
<img width="300" height="150" alt="medicineorderfinish" src="https://github.com/user-attachments/assets/87b8e540-64a7-424e-b5a8-ff28db973397" />

After completing the necessary steps, the system will direct you to our home page.

## Web Doctor

<img width="1000" height="500" alt="speakdoctor" src="https://github.com/user-attachments/assets/b65c7c49-39dd-4e18-8adc-8a42047517da" />

Our system supports both voice and text input. 3D Web Doctor switches to speech mode with text input and goes into standby mode after the voice command is executed.

You can select the options by clicking Even if you select an option, you can change it until the system moves on to the next question. 
After selecting an option, the system will move on to the next question within a few seconds.

<img width="1000" height="500" alt="answertrue" src="https://github.com/user-attachments/assets/dde4cd04-caf5-4dc5-9af6-f0757bd92ed9" />

When the system is first opened, it aims to determine your general condition. It then uses specialized questions to identify your specific condition.

<img width="400" height="400" alt="customquestion" src="https://github.com/user-attachments/assets/5b76b08b-553d-4458-b6b6-3f426bbc302b" />

<img width="400" height="400" alt="suggestkg" src="https://github.com/user-attachments/assets/6ceb9798-f8fb-44bb-8934-5bd030888c5d" />

After the system determines your illness and sub-illnesses, it requests your weight information (and fever if necessary) for treatment 
(age information is obtained from the date of birth, please enter the actual date of birth).

After this stage, the system offers treatment recommendations and, if necessary, recommends medication and dosage.

<img width="400" height="450" alt="suggestdose" src="https://github.com/user-attachments/assets/c5f66e08-4d70-4ed8-9050-d6adfbcdb563" />

The system has a total of 12 different general recommendations.
However, leaving the general meaning of 12 different sentences the same, there are 2260 different sentences in total.
The probability of selecting each of these sentences is not equal. The usage of words in daily life varies from more frequent to less frequent.

When sentences change, they change not with their immediate meanings but with their direct synonyms. For example, if a sentence is a suggestion, all sentences become 
suggestions, and if it's an imperative, all sentences become imperatives, all the way down to the order, which remains constant.

The system will direct you to transactions such as transfer to the medical medicine cabinet and medication registration within 7 seconds.
7 seconds is the time it takes for the brain to perceive and make a decision. That's why it was determined to be 7 seconds.

You can access your medication record (which translates to "Özgecmiş") by clicking the button above or using the /resume link. This is where you'll see all your records, from beginning to end.

<img width="1000" height="500" alt="resume" src="https://github.com/user-attachments/assets/d56025b9-f782-456c-9eed-ab24a5345839" />

If you will not be using the medicine cabinet after this stage, you are not required to register with the pharmacy.

After 7 seconds, the system will direct you to a new page /save_medicine.

## Medical Medicine Cabinet Confirm Procedures

<img width="500" height="450" alt="control" src="https://github.com/user-attachments/assets/075d04f1-8742-4a02-bd2c-e42a0705e117" />

Assuming you've already registered with the pharmacy, the pharmacy will ask you for your pharmacy information again to match the pharmacy. The "Confirmation Code" you entered in your pharmacy registration will be requested at this stage. This code is also required for reading data from the medical medicine cabinet.

The system will ask you to re-enter the information until you enter it correctly at this stage (until you match the pharmacy).

After the check, the medical medicine cabinet transfer process begins with this stage.

<img width="500" height="450" alt="medicalcontrol" src="https://github.com/user-attachments/assets/00484eca-e792-4ce6-b0c9-d5d5f02a52b8" />

The medical medicine cabinet approval process is summarized as follows: Should it be forwarded to the medical medicine cabinet? If yes, fill out the general justification. If no, ask if you want to fill out the detailed justification. If you want to fill out the detailed justification, fill out the general justification immediately after the detailed justification. If you don't want to fill out the detailed justification, fill out the general justification. Then save the results with all the details in SQL. Update the information on the (which means to turkish "Özgecmiş") page by adding the forwarding processes.

<strong>Accept:</strong>

<img width="193" height="142" alt="accept" src="https://github.com/user-attachments/assets/51b43290-fc8c-4bb7-a401-3529be9cf3a0" />

<strong>Refuse:</strong>

<img width="168" height="95" alt="refuse1" src="https://github.com/user-attachments/assets/8a614bce-ec5a-4baf-a953-aa7c1928d963" />
<img width="195" height="133" alt="detailrefuse" src="https://github.com/user-attachments/assets/cd26deea-d7b7-4510-9d9d-c933700f625e" />
<img width="229" height="178" alt="refuse3" src="https://github.com/user-attachments/assets/ba510960-e04f-4258-99a9-f03b5eb9766f" />
<img width="224" height="190" alt="refuse2" src="https://github.com/user-attachments/assets/f7bd46fc-317c-4e43-8518-827c22829fb0" />

Once all the operations are completed, the screen will look like this:

<img width="450" height="450" alt="userlastdata" src="https://github.com/user-attachments/assets/382f86c0-7f44-490a-83a6-578a50333df5" />

From here, the user can either report new issues to 3D Web Doctor via the "Yeniden Başlat" button on the Home Page. They can also log out via the "Çıkış" button. They can also review all their records via the "Özgeçmiş" button.

## SQL's

All results are saved in SQL to be always available!

<strong>Users SQL:</strong>

<img width="1000" height="100" alt="userssql" src="https://github.com/user-attachments/assets/8d2d1a81-1ecc-4905-8293-621a0256fb20" />

<strong>Ills SQL:</strong>

<img width="1000" height="90" alt="illssql" src="https://github.com/user-attachments/assets/799029cf-5c62-454c-ac90-f87e2d0be450" />

<strong>Medicine Result SQL:</strong>

<img width="1000" height="100" alt="medicine_resultsql" src="https://github.com/user-attachments/assets/7a858de8-8b70-420a-9073-6288feb5cb9b" />

<strong>Pharmacies SQL:</strong>

<img width="1000" height="80" alt="pharmaciessql" src="https://github.com/user-attachments/assets/dd1aa1f8-1417-4ccb-92e6-d76695d600b2" />

<strong>Pharmacy Result SQL:</strong>

<img width="1000" height="100" alt="pharmacy_resultsql" src="https://github.com/user-attachments/assets/eafc4cab-36b1-42e6-aefd-1c50eaf3566f" />

## 3D Web Doctor Platform + Medical Medicine Cabinet

<img width="1000" alt="Project" src="https://github.com/user-attachments/assets/9135ca31-7a1a-452b-ab04-145d39fefac3" />
