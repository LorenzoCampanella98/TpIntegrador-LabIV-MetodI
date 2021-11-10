<?php namespace DAO;

    use Models\Company as Company;

    interface ICompanyDAO
    {
        public function Add(Company $company);
        public function GetAll();
        public function Remove($id);
        public function GetById($id);
        public function SearchCuit($cuit);
        public function SearchName($name);
        public function ChangeStatus($id);
        public function Modify($id,$name,$company_link,$aboutUs,$description,$active);
        public function Search($id);
        public function ListFilter($name);
    }

?>