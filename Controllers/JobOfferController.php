<?php namespace Controllers;

    use DAO\CompanyDAO;
    use Models\JobOffer as JobOffer;
    use DAO\JobOfferDAO as JobOfferDAO;

    use DAO\CompanyOkDAO as CompanyOkDAO; // Lo usare para el add de Job Offer y LA MUESTRA COMPLETA DE JOB OFFER
    use Models\CompanyOk as CompanyOk;

    use DAO\ApplicationDAO as ApplicationDAO; //la funcion SearchForApplications viene desde list-application es necesario el dao para tener la lista 

class JobOfferController
    {
        private $jobOfferDAO;
        private $companyOkDAO;
        public function __construct()
        {
            $this->jobOfferDAO = new JobOfferDAO;
            $this->companyOkDAO = new CompanyOkDAO; //es para las muestras complejas de search
        }

        public function ShowAddView()
        {
            $companyList = $this->companyOkDAO->GetAll();
            $jobPositionList = $this->jobOfferDAO->FilterJobPositionWithActiveCareers();
           // var_dump($jobPositionData);
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

        public function ShowSearchView()
        {
           /* $companyList = $this->companyDAO->GetAll(); //porque el search view muestra todas las companias tambien
            $company = new Company(); //par que no tire error la view -> ira vacio se realiza la busqueda, se va a la funcion Search y se llena -> luego a view otra vez pero con contenido*/
            $careerList = $this->jobOfferDAO->RetrieveDataCareers();
            $companyList = $this->companyOkDAO->GetAll();
            $jobOfferList = $this->jobOfferDAO->GetAll();
            $jobPositionList = $this->jobOfferDAO->FilterJobPositionWithActiveCareers(); // menu del filtro
            $jobOffer = new JobOffer();
            $jobPosition = null; //porque la muestra es completa y muestra estos datos tambien
            $career = null; //porque la muestra es completa y muestra estos datos tambien
            $company = new CompanyOk();
            require_once(VIEWS_PATH."search-jobOffer.php");
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
                $jobOffer->setJobPositionId($jobPositionId);
                $jobOffer->setCompanyId($companyId);
                //$jobOffer->setCareerId($careerId); // CAMBIAR
                $jobOffer->setActive(1); //no me toma true
                $this->jobOfferDAO->Add($jobOffer);
               $this->ShowAddView();
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

        public function Remove($id)
        {        
            $this->jobOfferDAO->Remove($id);

            $this->ShowListView();
        }

        public function Search($id)
        {
            $jobOfferList = $this->jobOfferDAO->GetAll();
            $careerList = $this->jobOfferDAO->RetrieveDataCareers();
            $companyList = $this->companyOkDAO->GetAll();
            $jobPositionList = $this->jobOfferDAO->FilterJobPositionWithActiveCareers(); // menu del filtro
            $jobOffer = new JobOffer();
            $jobOffer = $this->jobOfferDAO->SearchJobOffer($id);
            $jobPosition = $this->jobOfferDAO->SearchJobPosition($jobOffer->getJobPositionId());
            $career = $this->jobOfferDAO->SearchCareer($jobOffer->getCareerId());
            $company = $this->companyOkDAO->Search($jobOffer->getCompanyId());
            require_once(VIEWS_PATH."search-jobOffer.php"); 
        }

        public function FilterByCareer($text)
        {
            
            $careerList = $this->jobOfferDAO->RetrieveDataCareers(); //menu del filtro
            $jobOfferList = $this->jobOfferDAO->ListFilterByCareer($text); 
            $jobPositionList = $this->jobOfferDAO->FilterJobPositionWithActiveCareers(); // menu del filtro
            $companyList = $this->companyOkDAO->GetAll(); //cuando selecciono muestro la comany
            $jobOffer = new JobOffer();
            $jobPosition = null; //porque la muestra es completa y muestra estos datos tambien
            $career = null; //porque la muestra es completa y muestra estos datos tambien
            $company = new CompanyOk();
            require_once(VIEWS_PATH."search-jobOffer.php");
        }

        public function FilterByJobPosition($text)
        {
            
            $careerList = $this->jobOfferDAO->RetrieveDataCareers();
            $jobOffer = new JobOffer();
            $jobPosition = null; //porque la muestra es completa y muestra estos datos tambien
            $career = null; //porque la muestra es completa y muestra estos datos tambien
            $company = new CompanyOk();
            $jobOfferList = $this->jobOfferDAO->ListFilterbyJobPosition($text);
            $jobPositionList = $this->jobOfferDAO->FilterJobPositionWithActiveCareers();
            $companyList = $this->companyOkDAO->GetAll();
            require_once(VIEWS_PATH."search-jobOffer.php");
        }

        public function SearchForApplications($id) //es igual que el search pero te lleva al application-list
        {
            
            $applicationDAO = new ApplicationDAO;
            $applicationList = $applicationDAO->GetStudentApplications($_SESSION["loggedUser"]->getStudentId()); //porque lo necesita list-application

            $jobOfferList = $this->jobOfferDAO->GetAll();
            $careerList = $this->jobOfferDAO->RetrieveDataCareers();
            $companyList = $this->companyOkDAO->GetAll();
            $jobPositionList = $this->jobOfferDAO->FilterJobPositionWithActiveCareers(); // menu del filtro
            $jobOffer = new JobOffer();
            $jobOffer = $this->jobOfferDAO->SearchJobOffer($id);
            $jobPosition = $this->jobOfferDAO->SearchJobPosition($jobOffer->getJobPositionId());
            $career = $this->jobOfferDAO->SearchCareer($jobOffer->getCareerId());
            $company = $this->companyOkDAO->Search($jobOffer->getCompanyId());
            require_once(VIEWS_PATH."list-application.php"); 
        }

    }


?>