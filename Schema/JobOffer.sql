CREATE DATABASE IF NOT EXISTS tpfinal;

USE tpfinal;

CREATE TABLE IF NOT EXISTS joboffers
(
    jobOfferId INT NOT NULL PRIMARY KEY,
    publicationDate  VARCHAR(30) NOT NULL,
    expiryDate  VARCHAR(30) NOT NULL,
    description VARCHAR(30) NOT NULL,
    skills VARCHAR(30) NOT NULL,
    tasks VARCHAR (30) NOT NULL,
    jobPositionId INT NOT NULL,
    companyId INT NOT NULL,
    careerId INT NOT NULL,
    active bit NOT NULL /* no toma true o false*/
)Engine=InnoDB;



DROP procedure IF EXISTS `JobOffers_Add`;

DELIMITER $$

CREATE PROCEDURE JobOffers_Add (IN jobOfferId CHAR(4),IN publicationDate VARCHAR(30), IN expiryDate VARCHAR(30) , 
IN description VARCHAR(30),IN skills VARCHAR(30),IN tasks VARCHAR(30),IN jobPositionId CHAR (4),IN companyId CHAR (4),IN careerId char (4),IN active boolean)
BEGIN
	INSERT INTO joboffers
        (joboffers.jobOfferId,joboffers.publicationDate,joboffers.expiryDate,joboffers.description,joboffers.skills,joboffers.tasks,joboffers.jobPositionId,
         joboffers.companyId,jobOffers.careerId,joboffers.active)
    VALUES
        (jobOfferId,publicationDate,expiryDate,description,skills,tasks,jobPositionId,companyId,careerId,active);
END$$

DELIMITER ;

DROP procedure IF EXISTS `JobOffers_GetAll`;

DELIMITER $$

CREATE PROCEDURE JobOffers_GetAll ()
BEGIN
	SELECT jobOfferId,publicationDate,publicationDate,expiryDate,description,skills,tasks,jobPositionId,companyId,careerId,active
    FROM joboffers;
END$$

DELIMITER ;

DROP procedure IF EXISTS `JobOffers_Remove`;

DELIMITER $$

CREATE PROCEDURE JobOffers_Remove (IN id INT)
BEGIN
	DELETE 
    FROM joboffers
    WHERE (joboffers.jobOfferId = id);
END$$

DELIMITER ;

DROP procedure IF EXISTS `JobOffers_ChangeStatus`;

DELIMITER $$

CREATE PROCEDURE JobOffers_ChangeStatus (IN id INT,iN newSatus boolean)
BEGIN
	UPDATE jobOffers set active = newSatus
    WHERE (jobOffers.jobOfferId = id);
END$$

DELIMITER ;

DROP procedure IF EXISTS `JobOffers_Modify`;

DELIMITER $$

CREATE PROCEDURE JobOffers_Modify (IN jobOfferId CHAR(4),IN description VARCHAR(30),IN skills VARCHAR(30),IN tasks VARCHAR (30),IN newSatus boolean)
BEGIN
	UPDATE joboffers set active = newSatus,description = description,skills = skills,tasks = tasks
    WHERE (joboffers.jobOfferId = jobOfferId);
END$$

DELIMITER ;