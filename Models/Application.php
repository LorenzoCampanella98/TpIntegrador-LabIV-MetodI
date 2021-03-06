<?php namespace Models;

class Application
{
    private $applicationId;
    private $applicationDate;
    private $user;
    private $jobOffer;
    private $description;
    private $cv;
    private $active;

    

    public function getApplicationId(){ return $this->applicationId; }
    public function setApplicationId($applicationId): self { $this->applicationId = $applicationId; return $this; }

    public function getApplicationDate(){ return $this->applicationDate; }
    public function setApplicationDate($applicationDate): self { $this->applicationDate = $applicationDate; return $this; }

    //public function getStudent(){ return $this->student; }
    //public function setStudent($student): self { $this->student = $student; return $this; }

    public function getJobOffer(){ return $this->jobOffer; }
    public function setJobOffer($jobOffer): self { $this->jobOffer = $jobOffer; return $this; }

    public function getDescription(){ return $this->description; }
    public function setDescription($description): self { $this->description = $description; return $this; }

    public function getActive(){ return $this->active; }
    public function setActive($active): self { $this->active = $active; return $this; }

    public function getCv(){ return $this->cv; }
    public function setCv($cv): self { $this->cv = $cv; return $this; }

    public function getUser(){ return $this->user; }
    public function setUser($user): self { $this->user = $user; return $this; }
}

?>