<?php namespace Controllers;

use Models\JobPosition as JobPosition;
use DAO\JobPositionDAO as JobPositionDAO;

class JobPositionController
{
    private $jobPositionDAO;

    public function __construct()
    {
        $this->jobPositionDAO = new JobPositionDAO();
    }

    public  function ShowAddView()
        {
            //require_once(VIEWS_PATH."add-beer.php");
        }

        public function ShowListView()
        {
            $jobPositionList = $this->jobPositionDAO->GetAll();
            require_once(VIEWS_PATH."jobPosition-list.php");
        }

        /*public function Add($code,$name,$beerType) //description, density, price defautl!!
        {
            $beer = new Beer();
            $beer->setCode($code);
            $beer->setName($name);
            $beer->setBeerType($beerType);
            $beer->setDescription("default");
            $beer->setDensity("default");
            $beer->setPrice(1);
            $this->beerDAO->Add($beer);
            $this->ShowAddView();
        }

        public function Remove($id){
            $this->beerDAO->Remove($id);
            $this->ShowListView();
        }
        */

        public function ReloadJson()
        {
            $this->jobPositionDAO->RetrieveDataFromAPI();
            $this->ShowListView();
        }


}



?>