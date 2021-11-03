<?php namespace DAO;

    use Models\CompanyOk as CompanyOk;

    interface ICompanyOkDAO
    {
        public function Add(CompanyOk $company);
        public function GetAll();
        public function Remove($id);
        public function GetById($id);
    }

?>