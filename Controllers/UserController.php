<?php namespace Controllers;

    
    use DAO\UserDAO as UserDAO;

    class UserController
    {
        private $userDAO;
        public function __construct()
        {
            $this->userDAO = new UserDAO;
        }

        public  function ShowAddView()
        {
            require_once(VIEWS_PATH."add-student.php");
        }

        public  function ShowAddViewUserCompany() //par registrarse como User Company
        {
            require_once(VIEWS_PATH."add-userCompany.php");
        }

        public function ShowListView()
        {
            $userList = $this->userDAO->GetAll();
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
            if($this->userDAO->checkConnectionAppi()==true)
            {
                $message=$this->userDAO->register($email,$pass);
                require_once(VIEWS_PATH."home.php");
            } else {
                $message = "API DESCONECTADA";
                require_once(VIEWS_PATH."home.php");
            }
            
        }

        public function Remove($id)
        {        
            $this->userDAO->Remove($id);

            $this->ShowListView();
        }

        public function AddAdmin($name,$fileNumber,$surname,$password,$email)
        {
            $this->userDAO->addAdmin($name,$fileNumber,$surname,$password,$email);
            $this->ShowAddAdminView();
        }

        public function RegisterUserCompany($email,$pass,$name)
        {
            $message = $this->userDAO->RegisterUserCompany($email,$pass,$name);
            require_once(VIEWS_PATH."home.php");
        }

        
    }
?>