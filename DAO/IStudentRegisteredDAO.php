<?php namespace DAO;

    use Models\StudentRegistered as StudentRegistered;

    interface IStudentRegisteredDAO
    {
        public function Add(StudentRegistered $student);
        public function GetAll();
        public function Remove($id);
        public function GetById($id);
    }


?>