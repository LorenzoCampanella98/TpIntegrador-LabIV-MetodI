<?php namespace DAO;

    use Models\User as User;

    interface IUserDAO
    {
        public function Add(User $user);
        public function GetAll();
        public function Remove($id);
        public function GetById($id);
        public function GetByEmailAndPasswordBD($email,$password);
        public function SearchByEmailApi($email);
        public function register($email,$password);
        public function registerUserCompany($email,$password,$name);
        public function addAdmin($name,$fileNumber,$surname,$password,$email);
        public function checkConnectionAppi();
        public function ChangePostulated($id);
    }


?>