CREATE DATABASE IF NOT EXISTS tpfinal;

USE tpfinal;

CREATE TABLE IF NOT EXISTS companies
(
    companyId int NOT NULL AUTO_INCREMENT PRIMARY KEY,
    creator_user int NOT NULL,
    name NVARCHAR(30) NOT NULL,
    cuit NVARCHAR(30) NOT NULL,
    company_link NVARCHAR(30) NOT NULL,
    aboutUs NVARCHAR(30) NOT NULL,
    description NVARCHAR(30) NOT NULL,
    active bit NOT NULL /* no toma true o false*/
)Engine=InnoDB;


DROP procedure IF EXISTS `Companies_GetById`;

DELIMITER $$

CREATE PROCEDURE Companies_GetById (IN companyId VARCHAR(100)) /*chekear*/
BEGIN
	SELECT companies.companyId
    FROM companies
    WHERE (companies.companyId = companyId);
END$$

DELIMITER ;

DROP procedure IF EXISTS `Companies_Add`;

DELIMITER $$

CREATE PROCEDURE Companies_Add (IN creator_user varchar(4),IN name VARCHAR(30), IN cuit VARCHAR(30),IN company_link VARCHAR(30),IN aboutUs VARCHAR (30),IN description VARCHAR (30),IN active boolean)
BEGIN
	INSERT INTO companies
        (companies.creator_user,companies.name,companies.cuit,companies.company_link,companies.aboutUs,companies.description,companies.active)
    VALUES
        (creator_user,name,cuit,company_link,aboutUs,description,active);
END$$

DELIMITER ;

DROP procedure IF EXISTS `Companies_GetAll`;

DELIMITER $$

CREATE PROCEDURE Companies_GetAll ()
BEGIN
	SELECT companyId,creator_user,name,cuit,company_link,aboutUs,description,active
    FROM companies;
END$$

DELIMITER ;

DROP procedure IF EXISTS `Companies_Remove`;

DELIMITER $$

CREATE PROCEDURE Companies_Remove (IN id INT)
BEGIN
	DELETE 
    FROM companies
    WHERE (companies.companyId = id);
END$$

DELIMITER ;

DROP procedure IF EXISTS `Companies_ChangeStatus`;

DELIMITER $$

CREATE PROCEDURE Companies_ChangeStatus (IN id INT,iN newSatus boolean)
BEGIN
	UPDATE companies set active = newSatus
    WHERE (companies.companyId = id);
END$$

DELIMITER ;

DROP procedure IF EXISTS `Companies_Modify`;

DELIMITER $$

CREATE PROCEDURE Companies_Modify (IN companyId CHAR(4),IN name VARCHAR(30),IN company_link VARCHAR(30),IN aboutUs VARCHAR (30),IN description VARCHAR (30),IN newSatus boolean)
BEGIN
	UPDATE companies set active = newSatus,name = name,company_link = company_link,aboutUs = aboutUs,description = description
    WHERE (companies.companyId = companyId);
END$$

DELIMITER ;

DROP procedure IF EXISTS `Company_GetByName_and_CreatorUser`;

DELIMITER $$

CREATE PROCEDURE Company_GetByName_and_CreatorUser (IN creator_user int,IN name VARCHAR (30)) /*chekear*/
BEGIN
	SELECT CompanyId,creator_user,name,cuit,company_link,aboutUs,description,active
    FROM companies
    WHERE (companies.creator_user = creator_user and companies.name = name);
END$$

DELIMITER ;