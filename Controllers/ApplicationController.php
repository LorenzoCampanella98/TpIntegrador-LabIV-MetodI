<?php namespace Controllers;

    use DAO\ApplicationDAO as ApplicationDAO;
    use Models\Application as Application;

    use Dao\StudentDAO as StudentDAO; // Porque cuando un estudiate se postula cambia el estado
    use Models\Student as Student;

    use DAO\JobOfferDAO as JobOfferDAO;
    use Models\JobOffer as JobOffer;
    use \Exception as Exception;
    use Models\CV as CV;

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

        public function ShowActiveApplications() //funcionalidad extra
        {
            $aux = $this->applicationDAO->GetAll();
            $applicationList = array();
            foreach ($aux as $application)
            {
                if($application->getActive()==1)
                {
                    array_push($applicationList,$application);
                }
            }
            require_once(VIEWS_PATH."list-application-admin.php");
        }

        public function Add($studentId,$jobOfferId,$description,$file)
        {   
            //$this->SubirCv($file); //----------------------------------------------------PORQUE NO ANDAAAAAAAA????????????
            var_dump($file);
        
            $actualDate = date('d-m-Y', time());
            $application = new Application();
            $application->setApplicationDate($actualDate);
            $application->setDescription($description);
            $application->setActive(1); //no me toma true

      
            $jobOffer = $this->jobOfferDAO->SearchJobOffer($jobOfferId); //RETORNA UNA JOB OFFER
            $student = $this->studentDAO->GetById($studentId);//RETORNA UN STUDENT
            
            $application->setStudent($student); 
            $application->setJobOffer($jobOffer);
            $application->setCv($file);

        
            $this->applicationDAO->Add($application);
            $this->studentDAO->ChangePostulated($studentId); //cambia a postulado
            $_SESSION["loggedUser"]->setPostulated(1); //porque si bien se actualiza la BD no se actualiza el session  porque cando entra aun no estaba postulad                                         
            $jobOffer=null; //lo necesito en la muestra
            $applicationList = $this->applicationDAO->GetStudentApplications($_SESSION["loggedUser"]->getStudentId());
            require_once(VIEWS_PATH."list-application.php");;
        }

        public function SubirCv($file)
        {

            try
            {
                $neededExtension = "pdf";
                $fileName = $file["name"];
                $tempFileName = $file["tmp_name"];
                $type = $file["type"];
                                   
                $filePath = UPLOADS_PATH.basename($fileName);            
                $fileType = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));

                if ($fileType == $neededExtension){  
                    if (move_uploaded_file($tempFileName, $filePath))
                    {
                        $cv = new CV();
                        $cv->setName($fileName);
                        $this->applicationDAO->addCV($cv);
                        $message = "CV subido";
                    }
                    else
                        $message = "Error en  CV!";
                }else{
                    ?>
                    
                <?php
                }
                (new HomeController)->Index();        
            }
            catch(Exception $ex)
            {
              //  $message = $ex->getMessage();
            }
            require_once(VIEWS_PATH."home.php");;
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
            $applicationList = $this->applicationDAO->GetStudentApplications($_SESSION["loggedUser"]->getStudentId()); //PORQUE TARDA TANTO LA FUNCION
            $jobOffer=null; //lo necesito en la muestra
            require_once(VIEWS_PATH."list-application.php");;
        }

        public function Declinar($id,$studentId)
        {
            //$this->applicationDAO->ChangeStatus($id);
            //$this->studentDAO->ChangePostulated($studentId);


            //--- ENVIO DE EMAIL --- //
            $user = $this->studentDAO->GetById($studentId);
            $to = $user->getEmail();
            $subject = "Baja de Aplicacion";
            $message =  $_SESSION["loggedUser"]->getName()."Ha dado de baja tu aplicacion con ID: ".$id;
            mail($to, $subject, $message); // NO ANDA LA FUNCION

            require_once(VIEWS_PATH."home.php");
        }


    }



?>