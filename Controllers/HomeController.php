<?php
    namespace Controllers;

    use DAO\StudentDAO as StudentDAO;
    use DAO\CompanyDAO as CompanyDAO;
    use DAO\JobOfferDAO as JobOfferDAO;
    use Models\Student as Student;

    class HomeController
    {
        private $StudentDAO;
        private $CompanyDAO;
        private $JobOfferDAO;
        
        public function __construct()
        {
            $this->StudentDAO = new StudentDAO();
            $this->CompanyDAO = new CompanyDAO();
            $this->JobOfferDAO = new JobOfferDAO();
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
                    $user=$this->StudentDAO->GetByEmailAndPasswordBD($email,$password);
                    if($user->getTypeStudentId()==2){ //se logueo un admin o una company -> NO chekea API
                        $_SESSION["loggedUser"]= $user;
                        $this->ShowAddView();
                    } else if ($user->getTypeStudentId()==3){
                        $_SESSION["loggedUser"]= $user;
                        $company = $this->CompanyDAO->GetByCreatorUserAndName($user->getStudentId(),$user->getName()); //verifico si tiene creado una Company
                        if($company!=null){
                            $_SESSION["companyUser"] = $company;
                            $jobOffer = $this->JobOfferDAO->GetByCreatorUserAndName($user->getStudentId(),$company->getCompanyId()); //si tiene company verifico si tiene creada la Job Offer
                            if ($jobOffer!=null)
                            {
                                $_SESSION["jobOfferUser"]=$jobOffer;
                            }
                        }
                        $this->ShowAddView();
                        } else {
                            $control_API = $this->StudentDAO->SearchByEmailApi($email); //primero se fija si existe y esta activo en api
                            if($control_API == 1)
                            {
                                $_SESSION["loggedUser"]= $user;
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