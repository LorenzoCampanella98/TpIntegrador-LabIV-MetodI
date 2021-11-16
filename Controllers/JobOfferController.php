<?php namespace Controllers;

    use Models\JobOffer as JobOffer;
    use DAO\JobOfferDAO as JobOfferDAO;

    use DAO\CompanyDAO as CompanyDAO; // Lo usare para el add de Job Offer y LA MUESTRA COMPLETA DE JOB OFFER
    use Models\Company as Company;

    use DAO\ApplicationDAO as ApplicationDAO; //la funcion SearchForApplications viene desde list-application es necesario el dao para tener la lista 


class JobOfferController
    {
        private $jobOfferDAO;
        private $companyDAO;
        public function __construct()
        {
            $this->jobOfferDAO = new JobOfferDAO;
            $this->companyDAO = new CompanyDAO; //es para las muestras complejas de search
        }

        public function ShowAddView()
        {
            $companyList = $this->companyDAO->GetAll();
            $jobPositionList = $this->jobOfferDAO->FilterJobPositionWithActiveCareers();
            require_once(VIEWS_PATH."add-jobOffer.php");
        }

        public function ShowListView()
        {
            $jobOfferList = $this->jobOfferDAO->GetAll();
            require_once(VIEWS_PATH."jobOffer-list.php");

        }

        public function ShowModifyView()
        {
           $jobOfferList = $this->jobOfferDAO->GetAll(); 
           require_once(VIEWS_PATH."modify-jobOffer.php");
        }

        public function ShowModifyUserCompany()
        {
            require_once(VIEWS_PATH."modify-jobOffer-userCompany.php");
        }
        public function ShowSearchView()
        {
           
            $jobOfferList = $this->jobOfferDAO->GetAll();
            $jobPositionList = $this->jobOfferDAO->FilterJobPositionWithActiveCareers(); // menu del filtro
            $jobOffer = new JobOffer();
            require_once(VIEWS_PATH."search-jobOffer.php");
        }

        public function ShowStudentListByJobOffer() //PARA LISTAR ALUMNOS POR JOB OFFER
        {
            $message=null;
            $jobOfferList = $this->jobOfferDAO->GetAll();
            $studentList=null;
            require_once(VIEWS_PATH."list-studentsByJobOffer.php");  
        }

        public function ShowStudentListByJobOfferUserCompany()
        {
            $studentList=$this->jobOfferDAO->ListStudentsFilterByJoboffer($_SESSION["jobOfferUser"]->getJobOfferId());
            require_once(VIEWS_PATH."list-applicants-userCompany.php");
        }

        public function Add($description,$skills,$tasks,$jobPositionId,$companyId)
        {
            $actualDate = date('d-m-Y', time());
                $expiryDate = date("d-m-Y",strtotime($actualDate."+ 1 month"));
                $jobOffer = new JobOffer();
                $jobOffer->setPublicationDate($actualDate);
                $jobOffer->setExpiryDate($expiryDate);
                $jobOffer->setDescription($description);
                $jobOffer->setSkills($skills);
                $jobOffer->setTasks($tasks);
                $jobPosition = $this->jobOfferDAO->GetJobPositionById($jobPositionId); //retorno el Job Position qu dentro tiene la career
                $jobOffer->setJobPosition($jobPosition); //meto en el job Offer el JobPosition que dentro tiene una career
                $jobOffer->setCompany($this->companyDAO->GetById($companyId)); //retonrna una company
                $jobOffer->setActive(1); //no me toma true
                $this->jobOfferDAO->Add($jobOffer);
                if ($_SESSION["loggedUser"]->getTypeStudentId()==3) {
                    $_SESSION["jobOfferUser"]= $this->jobOfferDAO->GetByCreatorUserAndName($_SESSION["loggedUser"]->getStudentId(),$companyId);
                    require_once(VIEWS_PATH."home.php");
                } else {
                     $this->ShowAddView();
                }
        }

        public function ChangeStatus($id)
        {
            $this->jobOfferDAO->ChangeStatus($id);
            $this->ShowListView();
        }

        public function Modify($id,$description,$skills,$tasks,$active)
        {
            $jobOfferList = $this->jobOfferDAO->GetAll();
            $this->jobOfferDAO->Modify($id,$description,$skills,$tasks,$active);
            $this->ShowModifyView();
        }

        public function ModifyUserCompany($description,$skills,$tasks)
        {
            $jobOffer = $_SESSION["jobOfferUser"];
            $id = $jobOffer->getJobOfferId();
            $active = $jobOffer->getActive();
            $this->jobOfferDAO->Modify($id,$description,$skills,$tasks,$active);
            $_SESSION["jobOfferUser"] = $this->jobOfferDAO->SearchJobOffer($id);
            require_once(VIEWS_PATH."home.php");
        }

        public function Remove($id)
        {        
            $this->jobOfferDAO->Remove($id);

            $this->ShowListView();
        }

        public function Search($id)
        {
            $jobOfferList = $this->jobOfferDAO->GetAll();
           
            $jobOffer = new JobOffer();
            $jobOffer = $this->jobOfferDAO->SearchJobOffer($id);
           
            require_once(VIEWS_PATH."search-jobOffer.php"); 
        }

        public function FilterByCareer($text)
        {
           
            $jobOfferList = $this->jobOfferDAO->ListFilterByCareer($text); 
            
            $jobOffer = new JobOffer();
            
            require_once(VIEWS_PATH."search-jobOffer.php");
        }

        public function FilterByJobPosition($text)
        {
            
           
            $jobOffer = new JobOffer();
            
            $jobOfferList = $this->jobOfferDAO->ListFilterbyJobPosition($text);
           
            require_once(VIEWS_PATH."search-jobOffer.php");
        }

        public function SearchForApplications($id) //es igual que el search pero te lleva al application-list
        {
            $message=null; //por si hay que mostrar un mensaje en la view
            $applicationDAO = new ApplicationDAO;
            $applicationList = $applicationDAO->GetStudentApplications($_SESSION["loggedUser"]->getStudentId()); //porque lo necesita list-application

            $jobOfferList = $this->jobOfferDAO->GetAll();
           
            $jobOffer = new JobOffer();
            $jobOffer = $this->jobOfferDAO->SearchJobOffer($id);
            
            if($jobOffer->getJobOfferId()==null) //por si se elimino la job offer y alguien ya habia aplicado
            {
                $message = "La job Offer Aplicada ya no se encuentra disponible";
                $jobOffer=null;
            }
            require_once(VIEWS_PATH."list-application.php"); 
        }

        public function ListStudentsByJobOffer($id) //PARA LISTAR ALUMNOS DE UNA JOB OFFER
        {
            $jobOfferList = $this->jobOfferDAO->GetAll();
            $studentList=$this->jobOfferDAO->ListStudentsFilterByJoboffer($id); // PORQUE TARDA TANTO ESTA FUNCION!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
            require_once(VIEWS_PATH."list-studentsByJobOffer.php"); 
        }

    }


?>