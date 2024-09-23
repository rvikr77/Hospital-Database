CREATE DATABASE `HOSPITALDB`;
USE `HOSPITALDB`;
CREATE TABLE `HOSPITAL`(
    `PH` INT,
    `NAME` VARCHAR(20),
    `AGE` INT,
    `GENDER` VARCHAR(7),
    `BP1` INT,
    `BP2` INT,
    `PULSE` INT,
    `ALLERGIES` VARCHAR(20),
    `HEIGHT` INT,
    `WEIGHT` INT,
    `PATIENT_DETAILS` VARCHAR(50),
    PRIMARY KEY(`PH`, `NAME`)
);
CREATE TABLE `STORAGE`(
    `PH` INT,
    `NAME` VARCHAR(20),
    `AGE` INT,
    `GENDER` VARCHAR(7),
    `BP1` INT,
    `BP2` INT,
    `PULSE` INT,
    `ALLERGIES` VARCHAR(20),
    `HEIGHT` INT,
    `WEIGHT` INT,
    `PATIENT_DETAILS` VARCHAR(50),
    PRIMARY KEY(`PH`, `NAME`)
);

-- Add a composite index to HOSPITAL table
CREATE INDEX idx_hospital_ph_name ON HOSPITAL (PH, NAME);

-- Add a composite index to STORAGE table
CREATE INDEX idx_storage_ph_name ON STORAGE (PH, NAME);

CREATE TABLE users (
    user_id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('patient', 'doctor') NOT NULL
);

