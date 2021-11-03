<?php namespace Controllers;

    
    use DAO\StudentRegisteredDAO as StudentRegisteredDAO;

    class StudentController
    {
        private $studentDAO;
        private $studentRegisteredDAO;
        public function __construct()
        {
            $this->studentRegisteredDAO = new StudentRegisteredDAO;
        }

        public  function ShowAddView()
        {
            require_once(VIEWS_PATH."add-student.php");
            //require_once(VIEWS_PATH."add-beer.php");
        }

        public function ShowListView()
        {
            //$studentList = $this->studentDAO->GetAll(); //VIEJO
            //require_once(VIEWS_PATH."student-list.php"); 

            $studentList = $this->studentRegisteredDAO->GetAll();
            require_once(VIEWS_PATH."student-list.php");
        }

        public function ShowHomeView() //la uso cuando registro
        {
            require_once(VIEWS_PATH."home.php");
        }

        

        public function ReloadJson()
        {
            $this->studentDAO->RetrieveDataFromAPI();
            $this->ShowListView();
        }

        public function Register($email,$pass)
        {
            $this->studentRegisteredDAO->register($email,$pass);
            $this->ShowHomeView();
        }

        public function Remove($id)
        {        
            $this->studentRegisteredDAO->Remove($id);

            $this->ShowListView();
        }
    }
?>