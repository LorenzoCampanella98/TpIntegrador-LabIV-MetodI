<?php namespace DAO;

    use DAO\IJobOfferDAO as IJobOfferDAO;
    use Models\JobOffer as JobOffer;
    use Models\JobPosition as JobPosition; //lo uso para la funcion reireve data jobPosition para usar en el add de job offer
    use DAO\Connection as Connection;
    use DAO\QueryType as QueryType;

    use DAO\ApplicationDAO as ApplicationDAO; //los uso para armar una lista de estudiantes que aplicarona a una job offer
    use DAO\UserDAO as UserDAO;

    use DAO\CompanyDAO as CompanyDAO; //ultima modificacion company dentro de JobOffer
    
    use Models\Career as Career;

    use Models\Application;

class JobOfferDAO implements IJobOfferDAO
    {
        private $connection;
        private $tablename="joboffers";

        public function Add(JobOffer $jobOffer)
        {
            $query = "CALL JobOffers_Add(?,?,?,?,?,?,?,?,?,?)";
            $parameters["creator_user"] = $_SESSION["loggedUser"]->getUserId();
            $parameters["publicationDate"]= $jobOffer->getPublicationDate();
            $parameters["expiryDate"] = $jobOffer->getExpiryDate();
            $parameters["description"] = $jobOffer->getDescription();
            $parameters["skills"] = $jobOffer->getSkills();
            $parameters["tasks"] = $jobOffer->getTasks();
            $parameters["jobPositionId"] = $jobOffer->getJobPosition()->getJobPositionId();
            $parameters["companyId"] = $jobOffer->getCompany()->getCompanyId();
            $parameters["careerId"] = $jobOffer->getJobPosition()->getCareer()->getCarreerId();
            $parameters["active"] = $jobOffer->getActive();

            $this->connection = Connection::GetInstance();

            $this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);

        }

        public function GetAll()
        {
            $companyADO = new CompanyDAO;
            $jobOfferList = array();
            $query = "Call JobOffers_GetAll()";
            $this->connection = Connection::GetInstance();
            $result = $this->connection->Execute($query,array(),QueryType::StoredProcedure);
            foreach($result as $row)
            {
                $jobOffer = new JobOffer();
                $jobOffer->setJobOfferId($row["jobOfferId"]);
                $jobOffer->setPublicationDate($row["publicationDate"]);
                $jobOffer->setExpiryDate($row["expiryDate"]);
                $jobOffer->setDescription($row["description"]);
                $jobOffer->setSkills($row["skills"]);
                $jobOffer->setTasks($row["tasks"]);
                $jobOffer->setJobPosition($this->GetJobPositionById($row["jobPositionId"]));
                $jobOffer->setCompany($companyADO->GetById($row["companyId"])); //devuelve un Comany
               // $jobOffer->setApplicants($this->ListStudentsFilterByJoboffer($row["jobOfferId"]));
               // echo "control";
                $jobOffer->setActive($row["active"]);
                array_push($jobOfferList, $jobOffer);
            }
            return $jobOfferList;
        }
        public function GetById($id)
        {
            $jobOfferList=$this->GetAll(); //traigo la company a modificar
            $jobOffer = new JobOffer();
            foreach($jobOfferList as $value) {
                if($value->getJobOfferId() == $id) //filtro busqueda
                {
                  $jobOffer = $value;
                }
            }
            return $jobOffer;
        }

        public function Remove($id)
        {
            $query = "CALL JobOffers_Remove(?)";
            $parameters["id"] =  $id;
            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);
        }

      
        public function ChangeStatus($id)
        {
            $jobOfferList=$this->GetAll(); //traigo la company a modificar
            $jobOffer = new JobOffer();
            foreach($jobOfferList as $value) {
                if($value->getJobOfferId() == $id) //filtro busqueda
                {
                  $jobOffer = $value;  
                }
            }
            $query = "CALL JobOffers_ChangeStatus(?,?)";
            $parameters["id"] =  $id;
            if($jobOffer->getActive()==0){
                
                $parameters["newSatus"] =1;
            } else {
                $parameters["newSatus"] =0;
            }
            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);
        }

        public function Modify($id,$description,$skills,$tasks,$active)
        {
            $jobOffer = $this->GetById($id);
            if($description==''){
                $description=$jobOffer->getDescription();
            }
            if($skills=='')
            {
                $skills=$jobOffer->getSkills();
            }
            if($tasks=='')
            {
                $tasks=$jobOffer->getTasks();
            }
            $query = "CALL JobOffers_Modify(?,?,?,?,?)";
            $parameters["JobOfferId"] =  $id;
            $parameters["description"]=$description;
            $parameters["skills"] =  $skills;
            $parameters["tasks"] =  $tasks;
            $parameters["active"] =  $active;
            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);
        }

        public function GetJobPositionById($id) // DESCOMPOSICION POR ID PASADO! FUNCION AGREGADA PARA COMPOSICION DE OBJ
        { //JOBOFFER->JOB POSITION->CAREER
            $jobPositionList = $this->RetrieveDataJobPosition();
            $careersList = $this->RetrieveDataCareers();
            $jobPosition = new JobPosition();
            $career = new Career  ();
            foreach($jobPositionList as $value)
            {
                if($value["jobPositionId"]==$id)
                {
                    $jobPosition->setJobPositionId($id);
                    $jobPosition->setDescription($value["description"]);
                    foreach ($careersList as $valueCareer)
                    {
                        if($value["careerId"]==$valueCareer["careerId"])
                        {
                            $career->setCarreerId($valueCareer["careerId"]);
                            $career->setDescription($valueCareer["description"]);
                            $career->setActive($valueCareer["active"]);
                        }
                    }
                    $jobPosition->setCareer($career);
                }
            }
            return $jobPosition;
        }

        private function RetrieveDataJobPosition() //carga en memoria todos los job position
        {
            $jobPositionList = array();
            $ch = curl_init();
            $url = 'https://utn-students-api.herokuapp.com/api/JobPosition';
            $httpheader = ['x-api-key: 4f3bceed-50ba-4461-a910-518598664c08'];
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $httpheader);
            $response = curl_exec($ch);
            if(curl_errno($ch))
            { 
                echo curl_error($ch);
            } else { 
                $decoded = json_decode($response, true);
            }
            curl_close($ch);
            $data = json_decode($response, true);
            $jobPositionList = $data;
            return $jobPositionList;
        }

        public function RetrieveDataCareers()
        {
            $careersList = array();
            $ch = curl_init();
            $url = 'https://utn-students-api.herokuapp.com/api/Career';
            $httpheader = ['x-api-key: 4f3bceed-50ba-4461-a910-518598664c08'];
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $httpheader);
            $response = curl_exec($ch);
            if(curl_errno($ch))
            { 
                echo curl_error($ch);
            } else { 
                $decoded = json_decode($response, true);
            }
            curl_close($ch);
            $data = json_decode($response, true);
            $careersList = $data;
            return $careersList;
        }

        public function FilterJobPositionWithActiveCareers()
        {
            $jobsList = $this->RetrieveDataJobPosition();
            $careersList =$this->RetrieveDataCareers();
            $jobFilterList = array();
            foreach($jobsList as $job)
            {
                foreach($careersList as $career)
            {
                if($job["careerId"]==$career["careerId"])
                {
                    if($career["active"]==true)
                    {
                        array_push($jobFilterList, $job);
                    }
                }
            }
            }
            return $jobFilterList;
        }

        private function loadCareerFromJobPosition($jobId)
        {
            $jobPositionList = $this->RetrieveDataJobPosition();
            $careerId = 0;
            foreach($jobPositionList as $value)
            {
                if($value["jobPositionId"]==$jobId)
                {
                    $careerId = $value["careerId"];
                }
            }
            return $careerId;
        }

        public function SearchJobOffer($id)
        {
            $jobOfferList=$this->GetAll(); //traigo la company a modificar
            $jobOffer = new JobOffer();
            foreach($jobOfferList as $value) {
                if($value->getJobOfferId() == $id) //filtro busqueda
                {
                  $jobOffer = $value;
                }
            }
            return $jobOffer;
        }

        public function SearchJobPosition($id) //para la muestra del search-jobOffer VER CONTROLADORA
        {
            $jobPositionList = $this->RetrieveDataJobPosition();
            $aux = null;
            foreach($jobPositionList as $value)
            {
                if($value["jobPositionId"]==$id)
                {
                    $aux = $value;
                }
            }
            return $aux; //retornaria el job position
        }

        public function SearchCareer($id) //para la muestra del search-jobOffer VER CONTROLADORA
        {
            $careerList = $this->RetrieveDataCareers();
            $aux = null;
            foreach($careerList as $value)
            {
                if($value["careerId"]==$id)
                {
                    $aux = $value;
                }
            }
            return $aux; //retornaria la career
        }

        
        public function ListFilterByCareer($text)
        {
            $list_jobOffer = $this->GetAll();
            $list_careers = $this->RetrieveDataCareers();
            $list_filter = array();
            $cadena_texto = "";
            foreach($list_jobOffer as $content)
                 {
                    $careerId = $content->getJobPosition()->getCareer()->getCarreerId();
                    foreach($list_careers as $career)
                    {
                        if($career['careerId']==$careerId)
                        {
                            $cadena_texto = $career['description'];
                        }
                    }
                    $flag = false;
                    if(stristr($cadena_texto, $text) !== false)
                    {
                        $jobOffer = new JobOffer();
                        $jobOffer = $content;
                        array_push($list_filter, $jobOffer);
                    }
                 }
            return $list_filter;
        }
    
        public function ListFilterbyJobPosition($text)
        {
            $list_jobOffer = $this->GetAll();
            $list_jobPosition = $this->RetrieveDataJobPosition();
            $list_filter = array();
            foreach($list_jobOffer as $content)
                 {
                    $jobPositionId = $content->getJobPosition()->getJobPositionId();
                    foreach($list_jobPosition as $jobPosition)
                    {
                        if($jobPosition['jobPositionId']==$jobPositionId)
                        {
                            $cadena_texto = $jobPosition['description'];
                        }
                    }
                    $flag = false;
                    if(stristr($cadena_texto, $text) !== false)
                    {
                        $jobOffer = new JobOffer();
                        $jobOffer = $content;
                        array_push($list_filter, $jobOffer);
                    }
                 }
            return $list_filter;
        }
        
        public function ListStudentsFilterByJoboffer($id) //para view de listar alumnos de job offer
        {
            //$UserDAO= new UserDAO;
            $applicationDAO = new ApplicationDAO;
            $applicationList = $applicationDAO->getAll();
            $userList = array();
            foreach ($applicationList as $application)
            {
                if($application->getJobOffer()->getJobOfferId()==$id)
                {
                    //$user=$application->getUser();
                    //array_push($userList,$user);
                    array_push($userList,$application->getUser());
                }
            }
            return $userList;
        }

        public function GetByCreatorUserAndName($creatorUserId,$companyId)
        {
            $companyADO = new CompanyDAO;
            $query = "Call JobOffers_GetAll()";
            $this->connection = Connection::GetInstance();
            $result = $this->connection->Execute($query,array(),QueryType::StoredProcedure); //tengo tods los datos de la BD
            $jobOffer = null;
            foreach($result as $row)
            {
                if($row["creator_user"]==$creatorUserId && $row["companyId"]==$companyId)
                {
                    $jobOffer = new JobOffer();
                    $jobOffer->setJobOfferId($row["jobOfferId"]);
                    $jobOffer->setPublicationDate($row["publicationDate"]);
                    $jobOffer->setExpiryDate($row["expiryDate"]);
                    $jobOffer->setDescription($row["description"]);
                    $jobOffer->setSkills($row["skills"]);
                    $jobOffer->setTasks($row["tasks"]);
                    $jobOffer->setJobPosition($this->GetJobPositionById($row["jobPositionId"]));
                    $jobOffer->setCompany($companyADO->GetById($row["companyId"])); //devuelve un Comany
                    $jobOffer->setActive($row["active"]);
                } 
            }
            return $jobOffer;  
        }

    }
?>