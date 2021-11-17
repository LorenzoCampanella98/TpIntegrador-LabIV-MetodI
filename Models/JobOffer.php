<?php namespace Models;

class JobOffer
{
    private $jobOfferId;
    private $publicationDate;
    private $expiryDate;
    private $description;
    private $skills;
    private $tasks;
    private $jobPosition;
    private $company;
    //private $careerId;
    private $active;
    private $applicants; //arreglo almacenara los aplicantes

    public function getJobOfferId(){ return $this->jobOfferId; }
    public function setJobOfferId($jobOfferId): self { $this->jobOfferId = $jobOfferId; return $this; }

    public function getPublicationDate(){ return $this->publicationDate; }
    public function setPublicationDate($publicationDate): self { $this->publicationDate = $publicationDate; return $this; }

    public function getExpiryDate(){ return $this->expiryDate; }
    public function setExpiryDate($expiryDate): self { $this->expiryDate = $expiryDate; return $this; }

    public function getDescription(){ return $this->description; }
    public function setDescription($description): self { $this->description = $description; return $this; }

    public function getSkills(){ return $this->skills; }
    public function setSkills($skills): self { $this->skills = $skills; return $this; }

    public function getTasks(){ return $this->tasks; }
    public function setTasks($tasks): self { $this->tasks = $tasks; return $this; }

    public function getJobPosition(){ return $this->jobPosition; }
    public function setJobPosition($jobPosition): self { $this->jobPosition = $jobPosition; return $this; }

    public function getCompany(){ return $this->company; }
    public function setCompany($company): self { $this->company = $company; return $this; }

    public function getActive(){ return $this->active; }
    public function setActive($active): self { $this->active = $active; return $this; }

    //public function getCareerId(){ return $this->careerId; }
    //public function setCareerId($careerId): self { $this->careerId = $careerId; return $this; }

    public function getApplicants(){ return $this->applicants; }
    public function setApplicants($applicants): self { $this->applicants = $applicants; return $this; }
}





?>