<?php namespace Controllers;

    use DAO\ApplicationDAO as ApplicationDAO;
    use Models\Application as Application;

    use Dao\UserDAO as UserDAO; // Porque cuando un estudiate se postula cambia el estado
    use Models\User as User;

    use DAO\JobOfferDAO as JobOfferDAO;
    use Models\JobOffer as JobOffer;
    use \Exception as Exception;
    use Models\CV as CV;
    use Controllers\EmailController as EmailController;

class ApplicationController
    {
        private $applicationDAO;
        private $userDAO;
        private $jobOfferDAO;
        public function __construct()
        {
            $this->applicationDAO = new ApplicationDAO();
            $this->userDAO = new UserDAO;
            $this->jobOfferDAO = new JobOfferDAO;
        }

        public function ShowListView()
        {
            $applicationList = $this->applicationDAO->GetStudentApplications($_SESSION["loggedUser"]->getUserId());
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

        public function Add($userId,$jobOfferId,$description,$file)
        {   
            $actualDate = date('d-m-Y', time());
            $application = new Application();
            $application->setApplicationDate($actualDate);
            $application->setDescription($jobOfferId); // WTF
            $application->setActive(1); //no me toma true

            
            $jobOffer = $this->jobOfferDAO->SearchJobOffer($userId); //WTF
            $user = $this->userDAO->GetById($description);//RETORNA UN STUDENT
            
            $application->setUser($user); 
            $application->setJobOffer($jobOffer);
            $application->setCv($file);
            
            $this->applicationDAO->Add($application);
            $this->userDAO->ChangePostulated($description); //cambia a postulado
            $_SESSION["loggedUser"]->setPostulated(1); //porque si bien se actualiza la BD no se actualiza el session  porque cando entra aun no estaba postulad                                         
            $jobOffer=null; //lo necesito en la muestra
            $applicationList = $this->applicationDAO->GetStudentApplications($_SESSION["loggedUser"]->getUserId());
            require_once(VIEWS_PATH."home.php");
        }

        public function SubirCv($description,$userId,$jobOfferId,$file)
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
            $this->Add($userId,$jobOfferId,$description,$fileName);
        }

        public function BajaAplication($id)
        {
            if($this->applicationDAO->CheckApplicationStatus($id)==1)
            {
                $this->applicationDAO->ChangeStatus($id);
                $this->userDAO->ChangePostulated($_SESSION["loggedUser"]->getUserId()); //cambia a postulado
                $_SESSION["loggedUser"]->setPostulated(0); //porque si bien se actualiza la BD no se actualiza el session
                                                        //porque cando entra aun no estaba postulad
            }
            $applicationList = $this->applicationDAO->GetStudentApplications($_SESSION["loggedUser"]->getUserId()); //PORQUE TARDA TANTO LA FUNCION
            $jobOffer=null; //lo necesito en la muestra
            require_once(VIEWS_PATH."list-application.php");;
        }

        public function Declinar($id,$userId)
        {
            $emailController = new EmailController;
            //baja de la acpplicacion y cambio de estado para el user
            $this->applicationDAO->ChangeStatus($id);
            $this->userDAO->ChangePostulated($userId);

            //--- ENVIO DE EMAIL --- //
            $user = $this->userDAO->GetById($userId);
            $to = $user->getEmail();
            $subject = "Baja de Aplicacion";
            $message =  $_SESSION["loggedUser"]->getName()."Ha dado de baja tu aplicacion con ID: ".$id;
            
            $emailController->sendEmail($to,$subject,$message);
            $message = ">>Aplicacion dada de baja por-> ".$_SESSION["loggedUser"]->getName()."Id Aplicacion: ".$id;
            $message1= ">>Student AVISADO-> ".$user->getName()." Email: ".$user->getEmail();
            $message2= ">>Correo enviado desde: lorenzocampanellaprueba@gmail.com";
            require_once(VIEWS_PATH."list-application-admin.php");
        }


    }



?>