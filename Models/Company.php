<?php namespace Models;

    class Company
    {
        private $companyId;
        private $name;
        private $cuit;
        private $company_link;
        private $aboutUs;
        private $description;
        private $active;

        

        public function getCompanyId(){ return $this->companyId; }
        public function setCompanyId($companyId): self { $this->companyId = $companyId; return $this; }

        public function getCuit(){ return $this->cuit; }
        public function setCuit($cuit): self { $this->cuit = $cuit; return $this; }

        public function getCompanyLink(){ return $this->company_link; }
        public function setCompanyLink($company_link): self { $this->company_link = $company_link; return $this; }

        public function getAboutUs(){ return $this->aboutUs; }
        public function setAboutUs($aboutUs): self { $this->aboutUs = $aboutUs; return $this; }

        public function getDescription(){ return $this->description; }
        public function setDescription($description): self { $this->description = $description; return $this; }

        public function getActive(){ return $this->active; }
        public function setActive($active): self { $this->active = $active; return $this; }

        public function getName(){ return $this->name; }
        public function setName($name): self { $this->name = $name; return $this; }
    }  




?> 