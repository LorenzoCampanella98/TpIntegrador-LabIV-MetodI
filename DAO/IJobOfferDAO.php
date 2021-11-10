<?php namespace DAO;

use Models\JobOffer as JobOffer;

interface IJobOfferDAO
{
    public function Add(JobOffer $jobOffer);
    public function GetAll();
    public function Remove($id);
    public function GetById($id);
    public function ChangeStatus($id);
    public function Modify($id,$description,$skills,$tasks,$active);
    public function RetrieveDataCareers(); // publica porque unos controllers la usan
    public function FilterJobPositionWithActiveCareers();
    public function SearchJobOffer($id);
    public function SearchJobPosition($id);
    public function SearchCareer($id);
    public function ListFilterByCareer($text);
    public function ListFilterbyJobPosition($text);
    public function ListStudentsFilterByJoboffer($id);
}


?>