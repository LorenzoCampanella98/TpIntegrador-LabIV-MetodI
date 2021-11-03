<?php
    namespace Controllers;

    use DAO\StudentDAO as StudentDAO;
    use DAO\StudentRegisteredDAO as StudentRegisteredDAO;
    use Models\StudentRegistered as StudentRegistered;

    class HomeController
    {
        private $studentDAO;
        private $studentRegisteredDAO;
        
        public function __construct()
        {
            $this->studentRegisteredDAO = new StudentRegisteredDAO();
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

        /*public function Login ($username,$password) //username = EMAIL , pass = phonenumbner 
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
        }*/

        public function Login($email,$password)
        {
            if($email =="admin" && $password =="admin"){ //si ingreso con admin adming se genera el user admin (no vive en api)
                $_SESSION["loggedUser"]=$this->studentRegisteredDAO->GenerateAdmin();
                $this->ShowAddView();
            } else {
                $control_API = $this->studentRegisteredDAO->SearchByEmailApi($email); //primero se fija si existe y esta activo en api
                if($control_API == 1)
                {
                    $student=$this->studentRegisteredDAO->GetByEmailAndPasswordBD($email,$password); //traigo el student de la bd si wp y email estan ok
                    if($student!=null)
                    {
                        $_SESSION["loggedUser"]= $student;
                        $this->ShowAddView();
                    } else {
                        $message = "USER INACTIVE"; //luego enviar al home y mostrar o no el error
                        $this->ShowAddView();
                    }
                } else {
                    $message = "USER INACTIVE"; //luego enviar al home y mostrar o no el error
                        $this->ShowAddView();
                }
            }
            require_once(VIEWS_PATH."home.php");
        }

        public function Logout()
        {
            $_SESSION=null; //si no hago esto se destruye la session pero queda basura en session, PORQUE ?
            session_destroy();
            $this->Index();
        }
    }
?>