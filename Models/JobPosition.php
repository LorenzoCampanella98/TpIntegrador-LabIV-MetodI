<?php namespace Models;

    class JobPosition
    {
        private $jobPositionId;
        private $description;
        private $career;

        public function getJobPositionId(){ return $this->jobPositionId; }
        public function setJobPositionId($jobPositionId): self { $this->jobPositionId = $jobPositionId; return $this; }

        public function getDescription(){ return $this->description; }
        public function setDescription($description): self { $this->description = $description; return $this; }

        public function getCareer(){ return $this->career; }
        public function setCareer($career): self { $this->career = $career; return $this; }
    }  




?> 