<?php
    namespace Controllers;

    use DAO\StudentDAO as StudentDAO;
    use Models\Student as Student;

    class HomeController
    {
        private $StudentDAO;
        
        public function __construct()
        {
            $this->StudentDAO = new StudentDAO();
        }

        public function Index()
        {
            require_once(VIEWS_PATH."home.php");
        }

        public function ShowAddView()
        {
            require_once(VIEWS_PATH."home.php");
        }

        public function Login($email,$password)
        {
            if($this->StudentDAO->checkConnectionAppi()==true) {
                $message=null;
                if($this->StudentDAO->GetByEmailAndPasswordBD($email,$password)!=null)
                {
                    $student=$this->StudentDAO->GetByEmailAndPasswordBD($email,$password);
                    if($student->getTypeStudentId()==2){ //se logueo el user administrador
                        $_SESSION["loggedUser"]= $student;
                        $this->ShowAddView();
                    } else {
                        $control_API = $this->StudentDAO->SearchByEmailApi($email); //primero se fija si existe y esta activo en api
                        if($control_API == 1)
                        {
                            $_SESSION["loggedUser"]= $student;
                            $this->ShowAddView();
                        } else {
                            $message = "USER INACTIVE"; //luego enviar al home y mostrar o no el error
                            $this->ShowAddView();
                        }
                    }
                } else {
                    $message = "PW/email incorrectos"; //luego enviar al home y mostrar o no el error
                    require_once(VIEWS_PATH."home.php");
                }
                require_once(VIEWS_PATH."home.php");
            } else {
                $message = "API DESCONECTADA";
                require_once(VIEWS_PATH."home.php");
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