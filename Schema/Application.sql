CREATE DATABASE IF NOT EXISTS tpfinal;

USE tpfinal;

CREATE TABLE IF NOT EXISTS applications
(
    applicationId int NOT NULL AUTO_INCREMENT PRIMARY KEY,
    applicationDate  VARCHAR(30) NOT NULL,
    studentId INT NOT NULL,
    jobOfferId INT NOT NULL,
    cv VARCHAR (30),
    description VARCHAR(30) NOT NULL,
    active bit NOT NULL /* no toma true o false*/
)Engine=InnoDB;



DROP procedure IF EXISTS `Applications_Add`;

DELIMITER $$

CREATE PROCEDURE Applications_Add (IN applicationDate VARCHAR(30), IN studentId CHAR (4),IN jobOfferId CHAR (4), IN cv VARCHAR(30)
IN description VARCHAR(30),IN active boolean)
BEGIN
	INSERT INTO applications
        (applications.applicationDate,applications.studentId,applications.jobOfferId,applications.cv,applications.description,
        applications.active)
    VALUES
        (applicationDate,studentId,jobOfferId,cv,description,active);
END$$

DELIMITER ;

DROP procedure IF EXISTS `Applications_GetAll`;

DELIMITER $$

CREATE PROCEDURE Applications_GetAll ()
BEGIN
	SELECT applicationId,applicationDate,studentId,jobOfferId,cv,description,active
    FROM applications;
END$$

DELIMITER ;

DROP procedure IF EXISTS `Aplications_Remove`;

DELIMITER $$

CREATE PROCEDURE Applications_Remove (IN id INT)
BEGIN
	DELETE 
    FROM applications
    WHERE (applications.applicationId = id);
END$$

DELIMITER ;

DROP procedure IF EXISTS `Applications_ChangeStatus`;

DELIMITER $$

CREATE PROCEDURE Applications_ChangeStatus (IN id INT,iN newSatus boolean)
BEGIN
	UPDATE applications set active = newSatus
    WHERE (applications.applicationId = id);
END$$

DELIMITER ;