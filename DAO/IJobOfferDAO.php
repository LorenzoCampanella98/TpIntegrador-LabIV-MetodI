<?php namespace DAO;

use Models\JobOffer as JobOffer;

interface IJobOfferDAO
{
    public function Add(JobOffer $jobOffer);
    public function GetAll();
    public function Remove($id);
}


?>