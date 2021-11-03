<?php namespace Controllers;

    use DAO\ApplicationDAO as ApplicationDAO;
    use Models\Application as Application;

    use Dao\StudentRegisteredDAO as StudentRegisteredDAO; // Porque cuando un estudiate se postula cambia el estado
    

class ApplicationController
    {
        private $applicationDAO;
        private $studentRegisteredDAO;
        public function __construct()
        {
            $this->applicationDAO = new ApplicationDAO;
            $this->studentRegisteredDAO = new StudentRegisteredDAO;
        }

        public function ShowAddView()
        {

        }

        public function ShowListView()
        {
            $applicationList = $this->applicationDAO->GetStudentApplications($_SESSION["loggedUser"]->getStudentId());
            $jobOffer=null; //lo necesito en la muestra
            require_once(VIEWS_PATH."list-application.php");
        }

        public function ShowModifyView()
        {

        }

        public function ShowSearchView()
        {

        }

        public function Add($studentId,$jobOfferId,$description)
        {
            $actualDate = date('d-m-Y', time());
            $application = new Application();
            $application->setApplicationDate($actualDate);
            $application->setStudentId($studentId);
            $application->setJobOfferId($jobOfferId);
            $application->setDescription($description);
            $application->setActive(1); //no me toma true
            $this->applicationDAO->Add($application);
            $this->studentRegisteredDAO->ChangePostulated($studentId); //cambia a postulado
            $_SESSION["loggedUser"]->setPostulated(1); //porque si bien se actualiza la BD no se actualiza el session
                                                        //porque cando entra aun no estaba postulad
            
            $jobOffer=null; //lo necesito en la muestra
            $applicationList = $this->applicationDAO->GetStudentApplications($_SESSION["loggedUser"]->getStudentId());
            require_once(VIEWS_PATH."list-application.php");;
        }


    }



?>