<?php namespace DAO;

    use Models\Student as Student;

    interface IStudentDAO
    {
        public function Add(Student $student);
        public function GetAll();
        public function Remove($id);
        public function GetById($id);
        public function GetByEmailAndPasswordBD($email,$password);
        public function SearchByEmailApi($email);
        public function register($email,$password);
        public function ChangePostulated($id);
    }


?>