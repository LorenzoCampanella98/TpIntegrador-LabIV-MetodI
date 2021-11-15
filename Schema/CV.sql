CREATE TABLE cvs
(
    cvId INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    studentId int not null;
    name NVARCHAR(100) NOT NULL
)Engine=InnoDB;

DELIMITER $$
CREATE PROCEDURE cv_add(IN Name VARCHAR(100),IN studentId VARCHAR(4))
BEGIN
    INSERT INTO cvs
        (name,studentId)
    VALUES
        (name,studentId);

END$$
DELIMITER ;