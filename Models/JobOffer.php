<?php namespace Models;

class JobOffer
{
    private $jobOfferId;
    private $publicationDate;
    private $expiryDate;
    private $description;
    private $skills;
    private $tasks;
    private $jobPositionId;
    private $companyId;
    private $careerId;
    private $active;

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

    public function getJobPositionId(){ return $this->jobPositionId; }
    public function setJobPositionId($jobPositionId): self { $this->jobPositionId = $jobPositionId; return $this; }

    public function getCompanyId(){ return $this->companyId; }
    public function setCompanyId($companyId): self { $this->companyId = $companyId; return $this; }

    public function getActive(){ return $this->active; }
    public function setActive($active): self { $this->active = $active; return $this; }

    public function getCareerId(){ return $this->careerId; }
    public function setCareerId($careerId): self { $this->careerId = $careerId; return $this; }
}





?>