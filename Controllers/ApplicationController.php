<?php namespace Controllers;

    use DAO\ApplicationDAO as ApplicationDAO;
    use Models\Application as Application;

    use Dao\StudentDAO as StudentDAO; // Porque cuando un estudiate se postula cambia el estado
    use Models\Student as Student;

    use DAO\JobOfferDAO as JobOfferDAO;
    use Models\JobOffer as JobOffer;

class ApplicationController
    {
        private $applicationDAO;
        private $studentDAO;
        private $jobOfferDAO;
        public function __construct()
        {
            $this->applicationDAO = new ApplicationDAO();
            $this->studentDAO = new StudentDAO;
            $this->jobOfferDAO = new JobOfferDAO;
        }

        public function ShowListView()
        {
            $applicationList = $this->applicationDAO->GetStudentApplications($_SESSION["loggedUser"]->getStudentId());
            $jobOffer=null; //lo necesito en la muestra
            require_once(VIEWS_PATH."list-application.php");
        }

        public function Add($studentId,$jobOfferId,$description)
        {
            $actualDate = date('d-m-Y', time());
            $application = new Application();
            $application->setApplicationDate($actualDate);
            $application->setDescription($description);
            $application->setActive(1); //no me toma true

      
            $jobOffer = $this->jobOfferDAO->SearchJobOffer($jobOfferId); //RETORNA UNA JOB OFFER
            $student = $this->studentDAO->GetById($studentId);//RETORNA UN STUDENT
            
            $application->setStudent($student); 
            $application->setJobOffer($jobOffer);

    
            $this->applicationDAO->Add($application);
            $this->studentDAO->ChangePostulated($studentId); //cambia a postulado
            $_SESSION["loggedUser"]->setPostulated(1); //porque si bien se actualiza la BD no se actualiza el session  porque cando entra aun no estaba postulad                                         
            $jobOffer=null; //lo necesito en la muestra
            $applicationList = $this->applicationDAO->GetStudentApplications($_SESSION["loggedUser"]->getStudentId());
            require_once(VIEWS_PATH."list-application.php");;
        }

        public function BajaAplication($id)
        {
            if($this->applicationDAO->CheckApplicationStatus($id)==1)
            {
                $this->applicationDAO->ChangeStatus($id);
                $this->studentDAO->ChangePostulated($_SESSION["loggedUser"]->getStudentId()); //cambia a postulado
                $_SESSION["loggedUser"]->setPostulated(0); //porque si bien se actualiza la BD no se actualiza el session
                                                        //porque cando entra aun no estaba postulad
            }
            $applicationList = $this->applicationDAO->GetStudentApplications($_SESSION["loggedUser"]->getStudentId());
            $jobOffer=null; //lo necesito en la muestra
            require_once(VIEWS_PATH."list-application.php");;
            }

    }



?>