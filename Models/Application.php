<?php namespace Models;

class Application
{
    private $applicationId;
    private $applicationDate;
    private $studentId;
    private $jobOfferId;
    private $description;
    private $active;

    

    public function getApplicationId(){ return $this->applicationId; }
    public function setApplicationId($applicationId): self { $this->applicationId = $applicationId; return $this; }

    public function getApplicationDate(){ return $this->applicationDate; }
    public function setApplicationDate($applicationDate): self { $this->applicationDate = $applicationDate; return $this; }

    public function getStudentId(){ return $this->studentId; }
    public function setStudentId($studentId): self { $this->studentId = $studentId; return $this; }

    public function getJobOfferId(){ return $this->jobOfferId; }
    public function setJobOfferId($jobOfferId): self { $this->jobOfferId = $jobOfferId; return $this; }

    public function getDescription(){ return $this->description; }
    public function setDescription($description): self { $this->description = $description; return $this; }

    public function getActive(){ return $this->active; }
    public function setActive($active): self { $this->active = $active; return $this; }
}

?>