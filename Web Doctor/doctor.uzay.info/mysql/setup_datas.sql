CREATE TABLE users (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT NOT NULL,
    name VARCHAR(30) NOT NULL,
    surname VARCHAR(30) NOT NULL,
    date_of_birth VARCHAR(10) NOT NULL,
    password VARCHAR(255) NOT NULL UNIQUE,
    information VARCHAR(500) NOT NULL,
    created_at TIMESTAMP DEFAULT (UTC_TIMESTAMP + INTERVAL 3 HOUR)
) CHARACTER SET utf8mb4
COLLATE utf8mb4_turkish_ci;

CREATE TABLE Ills (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT NOT NULL,
    medicine VARCHAR(30) NOT NULL,
    name VARCHAR(30) NOT NULL,
    surname VARCHAR(30) NOT NULL,
    age VARCHAR(20) NOT NULL,
    weight DOUBLE NOT NULL,
    dose VARCHAR(14) NOT NULL,
    daily_amount VARCHAR(14) NOT NULL,
    discomfort VARCHAR(100) NOT NULL,
    sub_discomfort VARCHAR(100) NOT NULL,
    guidance VARCHAR(200) NOT NULL,
    created_at TIMESTAMP DEFAULT (UTC_TIMESTAMP + INTERVAL 3 HOUR)
) CHARACTER SET utf8mb4
COLLATE utf8mb4_turkish_ci;

CREATE TABLE pharmacies (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    address VARCHAR(255) NOT NULL,
    confirmation_code VARCHAR(255) NOT NULL,
    medicine_order VARCHAR(4) NOT NULL,
    created_at TIMESTAMP DEFAULT (UTC_TIMESTAMP + INTERVAL 3 HOUR)
) CHARACTER SET utf8mb4
COLLATE utf8mb4_turkish_ci;

CREATE TABLE medicine_results (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT NOT NULL,
    name VARCHAR(30) NOT NULL,
    surname VARCHAR(30) NOT NULL,
    information VARCHAR(500) NOT NULL,
    ill_id VARCHAR(6) NOT NULL,
    pharmacy VARCHAR(100) NOT NULL,
    medicine VARCHAR(30) NOT NULL,
    conclusion_rationale VARCHAR(402) NOT NULL,
    detail_conclusion_rationale VARCHAR(500),
    result VARCHAR(1) NOT NULL,
    created_at TIMESTAMP DEFAULT (UTC_TIMESTAMP + INTERVAL 3 HOUR)
) CHARACTER SET utf8mb4
COLLATE utf8mb4_turkish_ci;

CREATE TABLE pharmacy_records (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    pharmacy VARCHAR(100) NOT NULL,
    pharmacy_id VARCHAR(6) NOT NULL,
    pharmacist_name VARCHAR(30) NOT NULL,
    pharmacist_surname VARCHAR(30) NOT NULL,
    pharmacist_password VARCHAR(255) NOT NULL,
    medicine_result_id VARCHAR(6) NOT NULL,
    result VARCHAR(1) NOT NULL,
    created_at TIMESTAMP DEFAULT (UTC_TIMESTAMP + INTERVAL 3 HOUR)
) CHARACTER SET utf8mb4
COLLATE utf8mb4_turkish_ci;
