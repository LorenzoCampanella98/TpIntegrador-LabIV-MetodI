<?php namespace Controllers;

    use Models\Company as Company;
    use DAO\CompanyDAO as CompanyDAO;

    class CompanyController
    {
        private $companyDAO;
        public function __construct()
        {
            $this->companyDAO = new CompanyDAO;
        }

        public  function ShowAddView()
        {
            require_once(VIEWS_PATH."add-company.php");
        }

        public function ShowListView()
        {
            $companyList = $this->companyDAO->GetAll();
            require_once(VIEWS_PATH."company-list.php");
        }

        public function ShowModifyView()
        {
            $companyList = $this->companyDAO->GetAll(); //porque el Modify view muestra todas las companias tambien
            require_once(VIEWS_PATH."modify-company.php");
        }

        public function ShowSearchView()
        {
            $companyList = $this->companyDAO->GetAll(); //porque el search view muestra todas las companias tambien
            $company = new Company(); //par que no tire error la view -> ira vacio se realiza la busqueda, se va a la funcion Search y se llena -> luego a view otra vez pero con contenido
            require_once(VIEWS_PATH."search-company.php");
        }

        public function Add($cuit,$address,$name) //description, density, price defautl!!
        {
            $company = new Company();
            $company->setCuit($cuit);
            $company->setAddress($address);
            $company->setName($name);
        
            $this->companyDAO->Add($company);
            $this->ShowAddView();
        }

        public function Modify($id,$cuit,$address,$name)
        {
            $companyList = $this->companyDAO->GetAll(); //porque el Modify view muestra todas las companias tambien
            $this->companyDAO->Modify($id,$cuit,$address,$name);
            $this->ShowModifyView();
        }

        public function Search($name)
        {
            $companyList = $this->companyDAO->GetAll(); //porque el search view muestra todas las companias tambien
            $company = new Company(); //par que no tire error la view -> ira vacio se realiza la busqueda, se va a la funcion Search y se llena -> luego a view otra vez pero con contenido
            $company = $this->companyDAO->Search($name);
            require_once(VIEWS_PATH."search-company.php");
        }

        public function ChangeStatus($id){ //REMOVE no elimina, cambia el estado a false
            $this->companyDAO->ChangeStatus($id);
            $this->ShowListView();
        }

        
        
    }

?>