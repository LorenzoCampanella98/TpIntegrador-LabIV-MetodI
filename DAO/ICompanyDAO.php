<?php namespace DAO;

    use Models\Company as Company;

    interface ICompanyDAO
    {
        public function Add(Company $company);
        public function GetAll();
        public function ChangeStatus($id);
        public function Modify($id,$name, $address, $active);//id encuentro, name, address, active modificables
        public function Search($name);//busco por nombre
    }

?>