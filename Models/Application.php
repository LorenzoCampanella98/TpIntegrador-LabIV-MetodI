<?php namespace Models;

class Application
{
    private $applicationId;
    private $applicationDate;
    private $student;
    private $jobOffer;
    private $description;
    private $active;

    

    public function getApplicationId(){ return $this->applicationId; }
    public function setApplicationId($applicationId): self { $this->applicationId = $applicationId; return $this; }

    public function getApplicationDate(){ return $this->applicationDate; }
    public function setApplicationDate($applicationDate): self { $this->applicationDate = $applicationDate; return $this; }

    public function getStudent(){ return $this->student; }
    public function setStudent($student): self { $this->student = $student; return $this; }

    public function getJobOffer(){ return $this->jobOffer; }
    public function setJobOffer($jobOffer): self { $this->jobOffer = $jobOffer; return $this; }

    public function getDescription(){ return $this->description; }
    public function setDescription($description): self { $this->description = $description; return $this; }

    public function getActive(){ return $this->active; }
    public function setActive($active): self { $this->active = $active; return $this; }
}

?>