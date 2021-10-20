<?php namespace Models;

    class Company
    {
        private $companyId;
        private $cuit;
        private $address;
        private $name;
        private $active;

        public function getCuit(){ return $this->cuit; }
        public function setCuit($cuit): self { $this->cuit = $cuit; return $this; }

        public function getAddress(){ return $this->address; }
        public function setAddress($address): self { $this->address = $address; return $this; }

        public function getName(){ return $this->name; }
        public function setName($name): self { $this->name = $name; return $this; }

        public function getCompanyId(){ return $this->companyId; }
        public function setCompanyId($companyId): self { $this->companyId = $companyId; return $this; }

        public function getActive(){ return $this->active; }
        public function setActive($active): self { $this->active = $active; return $this; }
    }

?>