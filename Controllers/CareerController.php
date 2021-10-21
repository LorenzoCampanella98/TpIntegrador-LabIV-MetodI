<?php namespace Controllers;

    use Models\Career as Career;
    use DAO\CareerDAO as CareerDAO;

    class CareerController
    {
        private $careerDAO;
        public function __construct()
        {
            $this->careerDAO = new CareerDAO;
        }

        public function ShowListView()
        {
            $careerList = $this->careerDAO->GetAll();
            require_once(VIEWS_PATH."career-list.php");
            
        }

        public function LoadBD()
        {
            $this->careerDAO->LoadBD();
            //$this->ShowListView();
        }
    }


?>