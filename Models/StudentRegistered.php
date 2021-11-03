<?php namespace Models;

class StudentRegistered{
    private $fileNumber;
    private $studentId;
    private $name;
    private $surname;
    private $email;
    private $password;
    private $postulated;

    

    public function getFileNumber(){ return $this->fileNumber; }
    public function setFileNumber($fileNumber): self { $this->fileNumber = $fileNumber; return $this; }

    public function getName(){ return $this->name; }
    public function setName($name): self { $this->name = $name; return $this; }

    public function getSurname(){ return $this->surname; }
    public function setSurname($surname): self { $this->surname = $surname; return $this; }

    public function getPassword(){ return $this->password; }
    public function setPassword($password): self { $this->password = $password; return $this; }

    public function getPostulated(){ return $this->postulated; }
    public function setPostulated($postulated): self { $this->postulated = $postulated; return $this; }

    public function getStudentId(){ return $this->studentId; }
    public function setStudentId($studentId): self { $this->studentId = $studentId; return $this; }

    public function getEmail(){ return $this->email; }
    public function setEmail($email): self { $this->email = $email; return $this; }
}



?>