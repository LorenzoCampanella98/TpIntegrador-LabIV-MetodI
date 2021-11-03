CREATE DATABASE IF NOT EXISTS tpfinal;

USE tpfinal;

CREATE TABLE IF NOT EXISTS studentRegistered
(
    studentId INT NOT NULL PRIMARY KEY,
    name NVARCHAR(30) NOT NULL,
    fileNumber NVARCHAR(30) NOT NULL,
    surname NVARCHAR(30) NOT NULL,
    password NVARCHAR(30) NOT NULL,
    email NVARCHAR(30) NOT NULL,
    postulated bit NOT NULL /* no toma true o false*/
    
)Engine=InnoDB;


DROP procedure IF EXISTS `StudentRegistered_GetById`;

DELIMITER $$

CREATE PROCEDURE StudentRegistered_GetById (IN studentId VARCHAR(100)) /*chekear*/
BEGIN
	SELECT studentRegistered.studentId
    FROM studentRegistered
    WHERE (studentRegistered.studentId = studentId);
END$$

DELIMITER ;

DROP procedure IF EXISTS `StudentRegistered_GetByEmail_and_Password`;

DELIMITER $$

CREATE PROCEDURE StudentRegistered_GetByEmail_and_Password (IN email VARCHAR(30),IN password VARCHAR (30)) /*chekear*/
BEGIN
	SELECT studentId,fileNumber,name,surname,password,email,postulated
    FROM studentRegistered
    WHERE (studentRegistered.email = email and studentRegistered.password = password);
END$$

DELIMITER ;

DROP procedure IF EXISTS `StudentRegistered_Add`;

DELIMITER $$

CREATE PROCEDURE StudentRegistered_Add (IN studentId CHAR(4), IN fileNumber VARCHAR(30),IN name VARCHAR(30),IN surname VARCHAR (30),IN password VARCHAR (30),IN email VARCHAR(30), IN postulated boolean)
BEGIN
	INSERT INTO studentRegistered
        (studentRegistered.studentId,studentRegistered.fileNumber,studentRegistered.name,studentRegistered.surname,studentRegistered.password,studentRegistered.email,studentRegistered.postulated)
    VALUES
        (studentId,fileNumber,name,surname,password,email,postulated);
END$$

DELIMITER ;

DROP procedure IF EXISTS `StudentRegistered_GetAll`;

DELIMITER $$

CREATE PROCEDURE StudentRegistered_GetAll ()
BEGIN
	SELECT studentId,fileNumber,name,surname,password,email,postulated
    FROM studentRegistered;
END$$

DELIMITER ;

DROP procedure IF EXISTS `c_Remove`;

DELIMITER $$

CREATE PROCEDURE StudentRegistered_Remove (IN id INT)
BEGIN
	DELETE 
    FROM studentRegistered
    WHERE (studentRegistered.studentId = id);
END$$

DELIMITER ;

DROP procedure IF EXISTS `StudentRegistered_ChangePostulated`;

DELIMITER $$

CREATE PROCEDURE StudentRegistered_ChangePostulated (IN id INT,iN newSatus boolean)
BEGIN
	UPDATE studentRegistered set postulated = newSatus
    WHERE (studentRegistered.studentId = id);
END$$

DELIMITER ;