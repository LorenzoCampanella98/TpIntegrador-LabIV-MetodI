<?php namespace Controllers;

    use Models\Student as Student;
    use DAO\StudentDAO as StudentDAO;

    class StudentController
    {
        private $studentDAO;
        public function __construct()
        {
            $this->studentDAO = new StudentDAO;
        }

        public  function ShowAddView()
        {
            //require_once(VIEWS_PATH."add-beer.php");
        }

        public function ShowListView()
        {
            $studentList = $this->studentDAO->GetAll();
            require_once(VIEWS_PATH."student-list.php");
        }

        /*public function Add($code,$name,$beerType) //description, density, price defautl!!
        {
            $beer = new Beer();
            $beer->setCode($code);
            $beer->setName($name);
            $beer->setBeerType($beerType);
            $beer->setDescription("default");
            $beer->setDensity("default");
            $beer->setPrice(1);
            $this->beerDAO->Add($beer);
            $this->ShowAddView();
        }

        public function Remove($id){
            $this->beerDAO->Remove($id);
            $this->ShowListView();
        }
        */


    }
?>