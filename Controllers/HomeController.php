<?php
    namespace Controllers;

    use DAO\StudentDAO as StudentDAO;
    use Models\Student as Student;

    class HomeController
    {
        private $studentDAO;
        
        public function __construct()
        {
            $this->studentDAO = new StudentDAO();
        }

        public function Index()
        {
            require_once(VIEWS_PATH."home.php");
        }

        public function ShowAddView()
        {
            //require_once(VIEWS_PATH."validate-session.php");
            //$student=new Student();
            require_once(VIEWS_PATH."home.php");
        }

        public function Login ($username,$password) //username = EMAIL , pass = phonenumbner 
        {
            //MODIFICAR LUEGO
            if($username =="admin" && $password =="admin"){ //si ingreso con admin adming se genera el user admin (no vive en api)
                $_SESSION["loggedUser"]=$this->studentDAO->GenerateAdmin();
                $this->ShowAddView();
            } else {
                $student = $this->studentDAO->GetByEmail($username); //busco en json -> modificar a api
                if($student != null){ //si no es null lo encontre
                    if(($student->getEmail()==$username)){ //necesario??
                        if(($student->getPhoneNumber()==$password))//necesario??
                        {
                            $_SESSION["loggedUser"]= $student;
                            $this->ShowAddView();
                        } 
                    }
                }
            }
        }

        public function Logout()
        {
            $_SESSION=null; //si no hago esto se destruye la session pero queda basura en session, PORQUE ?
            session_destroy();
            $this->Index();
        }
    }
?>