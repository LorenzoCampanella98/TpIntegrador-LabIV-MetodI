CREATE DATABASE IF NOT EXISTS tpfinal;

USE tpfinal;

CREATE TABLE IF NOT EXISTS careers 
(
    careerId INT NOT NULL PRIMARY KEY,
    description NVARCHAR(100) NOT NULL, /*description lo toma malaa*/
    active bit NOT NULL /* no toma true o false*/
)Engine=InnoDB;


DROP procedure IF EXISTS `Careers_GetById`;

DELIMITER $$

CREATE PROCEDURE Careers_GetById (IN careerId VARCHAR(100))
BEGIN
	SELECT careers.careerId
    FROM careers
    WHERE (careers.careerId = careerId);
END$$

DELIMITER ;

DROP procedure IF EXISTS `Careers_Add`;

DELIMITER $$

CREATE PROCEDURE Careers_Add (IN careerId CHAR(4), IN description VARCHAR(100), IN active boolean)
BEGIN
	INSERT INTO careers
        (careers.careerId, careers.description, careers.active)
    VALUES
        (careerId, description, active);
END$$

DELIMITER ;

DROP procedure IF EXISTS `Careers_GetAll`;

DELIMITER $$

CREATE PROCEDURE Careers_GetAll ()
BEGIN
	SELECT careerId, description, active
    FROM careers;
END$$

DELIMITER ;