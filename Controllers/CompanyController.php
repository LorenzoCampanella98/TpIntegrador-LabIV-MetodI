<?php namespace Controllers;


    use DAO\CompanyOkDAO as CompanyOkDAO;
    use Models\CompanyOk as CompanyOk;
    
    class CompanyController
    {
        private $companyDAO;
        private $companyOkDAO;

        public function __construct()
        {
            $this->companyOkDAO =  new CompanyOkDAO;
        }

        public  function ShowAddView()
        {
            $message = null;
            require_once(VIEWS_PATH."add-company.php");
        }

        public function ShowListView()
        {
           // $companyList = $this->companyDAO->GetAll();
            $companyList = $this->companyOkDAO->GetAll();
            require_once(VIEWS_PATH."company-list.php");
        }

        public function ShowModifyView()
        {
           // $companyList = $this->companyDAO->GetAll(); //porque el Modify view muestra todas las companias tambien
           $companyList = $this->companyOkDAO->GetAll(); 
           require_once(VIEWS_PATH."modify-company.php");
        }

        public function ShowSearchView()
        {
           /* $companyList = $this->companyDAO->GetAll(); //porque el search view muestra todas las companias tambien
            $company = new Company(); //par que no tire error la view -> ira vacio se realiza la busqueda, se va a la funcion Search y se llena -> luego a view otra vez pero con contenido*/
            
            $companyList = $this->companyOkDAO->GetAll(); 
            $company = new CompanyOk();
            require_once(VIEWS_PATH."search-company.php");
        }

        /*public function Add($cuit,$address,$name) //description, density, price defautl!!
        {
            
            if ($this->companyDAO->SearchCuit($cuit) == false){
                $company = new Company();
                $company->setCuit($cuit);
                $company->setAddress($address);
                $company->setName($name);
                $this->companyDAO->Add($company);
                $this->ShowAddView();
            } else {
                $mesage = "error cuit repetido";
                $this->ShowAddView();
            } 
        }*/

        public function Add($cuit,$name,$company_link,$aboutUs,$description)
        {
            if ($this->companyOkDAO->SearchCuit($cuit) == false){
                if($this->companyOkDAO->SearchName($name)==false){
                    $company = new CompanyOk();
                    $company->setCuit($cuit);
                    $company->setName($name);
                    $company->setCompanyLink($company_link);
                    $company->setAboutUs($aboutUs);
                    $company->setDescription($description);
                    $company->setActive(1); //no me toma el true 
                    $this->companyOkDAO->Add($company);
                    $this->ShowAddView();
                } else {
                    $message = "Error name repetido";
                    require_once(VIEWS_PATH."add-company.php");
                }
            } else {
                $message = "error cuit repetido";
                require_once(VIEWS_PATH."add-company.php");
            } 
        }

        /*public function Modify($id,$name ,$address,$active)
        {
            $companyList = $this->companyDAO->GetAll(); //porque el Modify view muestra todas las companias tambien
            $this->companyDAO->Modify($id,$address,$name,$active);
            $this->ShowModifyView();
        }*/

        public function Modify($id,$name,$company_link,$aboutUs,$description,$active)
        {
            $companyList = $this->companyOkDAO->GetAll(); //porque el Modify view muestra todas las companias tambien
            $this->companyOkDAO->Modify($id,$name,$company_link,$aboutUs,$description,$active);
            $this->ShowModifyView();
        }
        

        /*public function Search($name)
        {
            $companyList = $this->companyDAO->GetAll(); //porque el search view muestra todas las companias tambien
            $company = new Company(); //par que no tire error la view -> ira vacio se realiza la busqueda, se va a la funcion Search y se llena -> luego a view otra vez pero con contenido
            $company = $this->companyDAO->Search($name);
            require_once(VIEWS_PATH."search-company.php");
        }*/

        public function Search($id)
        {
            $companyList = $this->companyOkDAO->GetAll();
            $company = new CompanyOk();
            $company = $this->companyOkDAO->Search($id);
            require_once(VIEWS_PATH."search-company.php"); 
        }

        /*public function ChangeStatus($id){ //REMOVE no elimina, cambia el estado a false
            $this->companyDAO->ChangeStatus($id);
            $this->ShowListView();
        }*/



        public function ChangeStatus($id)
        {
            $this->companyOkDAO->ChangeStatus($id);
            $this->ShowListView();
        }



        /*public function Filter($name){
            $companyList = $this->companyDAO->RetrieveDataFilter($name);
            $company = new Company(); //par que no tire error la view -> ira vacio se realiza la busqueda, se va a la funcion Search y se llena -> luego a view otra vez pero con contenido
            //var_dump($companyList);
            require_once(VIEWS_PATH."search-company.php");
        }*/

        public function Filter($name)
        {
            $companyList = $this->companyOkDAO->ListFilter($name);
            $company = new CompanyOk();
            require_once(VIEWS_PATH."search-company.php");
        }

        
        
    }

?>