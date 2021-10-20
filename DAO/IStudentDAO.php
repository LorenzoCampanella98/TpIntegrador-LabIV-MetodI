<?php namespace DAO;

    use Models\Student as Student;

    interface IStudentDAO
    {
        public function Add(Student $student);
        public function GetAll();
        public function Remove($id); //desactivada, no se tienen que elinar , no se toca la api
        public function GetByEmail($email);
        public function GenerateAdmin($message = "admin");
    }
?>