CREATE DATABASE IF NOT EXISTS tpfinal;

USE tpfinal;

CREATE TABLE IF NOT EXISTS typeStudent
(
    typeStudentId int NOT NULL AUTO_INCREMENT PRIMARY KEY,
    type  VARCHAR(30) NOT NULL
)Engine=InnoDB;

INSERT INTO typestudent
    (type)
VALUES
    ('student'),
    ('admin'),
    ('company');