<?php namespace Controllers;


    use DAO\CompanyDAO as CompanyDAO;
    use Models\Company as Company;
    
    class CompanyController
    {
        private $companyDAO;

        public function __construct()
        {
            $this->companyDAO =  new CompanyDAO;
        }

        public  function ShowAddView()
        {
            $message = null;
            require_once(VIEWS_PATH."add-company.php");
        }

        public function ShowListView()
        {
            $companyList = $this->companyDAO->GetAll();
            require_once(VIEWS_PATH."company-list.php");
        }

        public function ShowModifyView()
        {
           $companyList = $this->companyDAO->GetAll(); 
           require_once(VIEWS_PATH."modify-company.php");
        }

        public function ShowModifyUserCompany()
        {
            require_once(VIEWS_PATH."modify-company-userCompany.php");
        }

        public function ShowSearchView()
        {
           $companyList = $this->companyDAO->GetAll(); 
            $company = new Company();
            require_once(VIEWS_PATH."search-company.php");
        }

        
        public function Add($cuit,$name,$company_link,$aboutUs,$description)
        {
            if ($this->companyDAO->SearchCuit($cuit) == false){
                if($this->companyDAO->SearchName($name)==false){
                    $company = new Company();
                    $company->setCuit($cuit);
                    $company->setName($name);
                    $company->setCompanyLink($company_link);
                    $company->setAboutUs($aboutUs);
                    $company->setDescription($description);
                    $company->setActive(1); //no me toma el true 
                    $this->companyDAO->Add($company);
                    if ($_SESSION["loggedUser"]->getTypeUserId()==3) {
                        $_SESSION["companyUser"]= $this->companyDAO->GetByCreatorUserAndName($_SESSION["loggedUser"]->getUserId(),$name); //actualizo para views
                        require_once(VIEWS_PATH."home.php");
                    } else {
                        $this->ShowAddView();
                    }
                } else {
                    $message = "Error name repetido";
                    require_once(VIEWS_PATH."add-company.php");
                }
            } else {
                $message = "error cuit repetido";
                require_once(VIEWS_PATH."add-company.php");
            } 
        }

        public function Modify($id,$name,$company_link,$aboutUs,$description,$active)
        {
            $companyList = $this->companyDAO->GetAll(); //porque el Modify view muestra todas las companias tambien
            $this->companyDAO->Modify($id,$name,$company_link,$aboutUs,$description,$active);
            $this->ShowModifyView();
        }

        public function ModifyUserCompany($company_link,$aboutUs,$description)
        {
            $company =  $_SESSION["companyUser"];
            $id = $company->getCompanyId();
            $name = $company->getName();
            $active = $company->getActive();
            $this->companyDAO->Modify($id,$name,$company_link,$aboutUs,$description,$active);
            $_SESSION["companyUser"] =  $this->companyDAO->Search($id);
            require_once(VIEWS_PATH."home.php");
        }

        public function Search($id)
        {
            $companyList = $this->companyDAO->GetAll();
            $company = new Company();
            $company = $this->companyDAO->Search($id);
            require_once(VIEWS_PATH."search-company.php"); 
        }

        public function ChangeStatus($id)
        {
            $this->companyDAO->ChangeStatus($id);
            $this->ShowListView();
        }

        public function Filter($name)
        {
            $companyList = $this->companyDAO->ListFilter($name);
            $company = new Company();
            require_once(VIEWS_PATH."search-company.php");
        }

        public function Remove($id)
        {
            $this->companyDAO->Remove($id);
            $this->ShowListView();
        }
        
    }

?>