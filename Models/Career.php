<?php namespace Models;

    class Career
    {
        private $carreerId;
        private $description;
        private $active;

        public function getCarreerId(){ return $this->carreerId; }
        public function setCarreerId($carreerId): self { $this->carreerId = $carreerId; return $this; }

        public function getDescription(){ return $this->description; }
        public function setDescription($description): self { $this->description = $description; return $this; }

        public function getActive(){ return $this->active; }
        public function setActive($active): self { $this->active = $active; return $this; }
    }  




?> 