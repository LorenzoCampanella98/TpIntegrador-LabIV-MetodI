<?php namespace DAO;

    use Models\Career as Career;

    interface ICareerDAO
    {
        public function Add(Career $career);// La uso para añadir a la BD -> envio careers desde RetrieveDataAPi
        public function GetAll();
        //public function Remove($id);
        public function GetById($id);
    }

?>