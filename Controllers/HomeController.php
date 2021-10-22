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
            $this->studentDAO->RetrieveDataFromAPI(); //actualizo todo de la base de datos
            
            //MODIFICAR LUEGO
            if($username =="admin" && $password =="admin"){ //si ingreso con admin adming se genera el user admin (no vive en api)
                $_SESSION["loggedUser"]=$this->studentDAO->GenerateAdmin();
                $this->ShowAddView();
            } else {
                $student = $this->studentDAO->GetByEmail($username); //busco en json -> modificar a api
                if($student != null){ //si no es null lo encontre
                    if(($student->getEmail()==$username && $student->getPhoneNumber()==$password)){ //necesario??
                        if(($student->getActive()==true))//necesario??
                        {
                            $_SESSION["loggedUser"]= $student;
                            $this->ShowAddView();
                        } else {
                            $message = "USER INACTIVE"; //luego enviar al home y mostrar o no el error
                            $this->ShowAddView();
                        }
                    }
                }
                $this->ShowAddView();
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