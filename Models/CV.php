<?php namespace Models;

    class CV
    {
        private $name;
        

        public function getName(){ return $this->name; }
        public function setName($name): self { $this->name = $name; return $this; }
    }

?>