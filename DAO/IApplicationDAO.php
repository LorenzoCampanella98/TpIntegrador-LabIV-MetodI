<?php namespace DAO;

use Models\Application as Application;

interface IApplicationDAO
{
    public function Add(Application $application);
    public function GetAll();
    public function Remove($id);
    public function GetStudentApplications($id);
    public function ChangeStatus($id);
    public function CheckApplicationStatus($id);
    public function addCV($cv);
}


?>