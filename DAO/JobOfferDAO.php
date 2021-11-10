<?php namespace DAO;

    use DAO\IJobOfferDAO as IJobOfferDAO;
    use Models\JobOffer as JobOffer;
    use Models\JobPosition as JobPosition; //lo uso para la funcion reireve data jobPosition para usar en el add de job offer
    use DAO\Connection as Connection;
    use DAO\QueryType as QueryType;

    use DAO\ApplicationDAO as ApplicationDAO; //los uso para armar una lista de estudiantes que aplicarona a una job offer
    use DAO\StudentDAO as StudentDAO;

class JobOfferDAO implements IJobOfferDAO
    {
        private $connection;
        private $tablename="joboffers";

        public function Add(JobOffer $jobOffer)
        {
            $query = "CALL JobOffers_Add(?,?,?,?,?,?,?,?,?)";
            $parameters["publicationDate"]= $jobOffer->getPublicationDate();
            $parameters["expiryDate"] = $jobOffer->getExpiryDate();
            $parameters["description"] = $jobOffer->getDescription();
            $parameters["skills"] = $jobOffer->getSkills();
            $parameters["tasks"] = $jobOffer->getTasks();
            $parameters["jobPositionId"] = $jobOffer->getJobPositionId();
            $parameters["companyId"] = $jobOffer->getCompanyId();
            $parameters["careerId"] = $this->loadCareerFromJobPosition($jobOffer->getJobPositionId());//la funcion necesita el id del jobposition seleccionado
            $parameters["active"] = $jobOffer->getActive();

            $this->connection = Connection::GetInstance();

            $this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);

        }

        public function GetAll()
        {
            $jobOfferList = array();
            $query = "Call JobOffers_GetAll()";
            $this->connection = Connection::GetInstance();
            $result = $this->connection->Execute($query,array(),QueryType::StoredProcedure);
            foreach($result as $row)
            {
                $company = new JobOffer();
                $company->setJobOfferId($row["jobOfferId"]);
                $company->setPublicationDate($row["publicationDate"]);
                $company->setExpiryDate($row["expiryDate"]);
                $company->setDescription($row["description"]);
                $company->setSkills($row["skills"]);
                $company->setTasks($row["tasks"]);
                $company->setJobPositionId($row["jobPositionId"]);
                $company->setCompanyId($row["companyId"]);
                $company->setCareerId($row["careerId"]);
                $company->setActive($row["active"]);
                array_push($jobOfferList, $company);
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
            foreach($list_jobOffer as $content)
                 {
                    $careerId = $content->getCareerId();
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
                    $jobPositionId = $content->getJobPositionId();
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
            $StudentDAO= new StudentDAO;
            $applicationDAO = new ApplicationDAO;
            $applicationList = $applicationDAO->getAll();
            $studentList = array();
            foreach ($applicationList as $application)
            {
                if($application->getJobOfferId()==$id)
                {
                    $student=$StudentDAO->GetById($application->getStudentId());
                    array_push($studentList,$student);
                }
            }
            return $studentList;
        }
    }
?>