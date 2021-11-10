<?php namespace Controllers;

    
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
            require_once(VIEWS_PATH."add-student.php");
        }

        public function ShowListView()
        {
            $studentList = $this->studentDAO->GetAll();
            require_once(VIEWS_PATH."student-list.php");
        }

        public function ShowHomeView() //la uso cuando registro
        {
            require_once(VIEWS_PATH."home.php");
        }

        public function ShowAddAdminView()
        {
            require_once(VIEWS_PATH."add-admin.php");
        }

        public function Register($email,$pass)
        {
            if($this->studentDAO->checkConnectionAppi()==true)
            {
                $message=$this->studentDAO->register($email,$pass);
                require_once(VIEWS_PATH."home.php");
            } else {
                $message = "API DESCONECTADA";
                require_once(VIEWS_PATH."home.php");
            }
            
        }

        public function Remove($id)
        {        
            $this->studentDAO->Remove($id);

            $this->ShowListView();
        }

        public function AddAdmin($name,$fileNumber,$surname,$password,$email)
        {
            $this->studentDAO->addAdmin($name,$fileNumber,$surname,$password,$email);
            $this->ShowAddAdminView();
        }

        
    }
?>