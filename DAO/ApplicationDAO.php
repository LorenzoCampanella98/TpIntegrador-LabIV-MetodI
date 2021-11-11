<?php namespace DAO;

    use DAO\IApplicationDAO as IApplicationDAO;
    use Models\Application as Application;
    use DAO\Connection as Connection;
    use DAO\QueryType as QueryType;

    use DAO\StudentDAO as StudentDAO;
    use DAO\JobOfferDAO as JobOfferDAO;

    /*use Models\Student as Student;
    use Models\JobOffer as JobOffer;*/

class ApplicationDAO implements IApplicationDAO
    {
        private $connection;
    
        public function Add(Application $application)
        {
            /*$student = new Student();
            $jobOffer = new JobOffer();
            $student=$application->getStudent();
            $jobOffer=$application->getJobOffer();
            var_dump($application);
            var_dump($application->getStudent());
            var_dump($application->getApplicationDate());
            var_dump($jobOffer);*/
            
            $query = "CALL Applications_Add(?,?,?,?,?)";

            
            $parameters["applicationDate"]= $application->getApplicationDate();
            $parameters["studentId"] = $application->getStudent()->getStudentId();
            $parameters["jobOfferId"] = $application->getJobOffer()->getJobOfferId();
            $parameters["description"] = $application->getDescription();
            $parameters["active"] = $application->getActive();
            
            $this->connection = Connection::GetInstance();

            $this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);
        }
        
        public function GetAll()
        {
            $studentDAO = new StudentDAO;
            $jobOfferDAO = new JobOfferDAO;
            $applicationList = array();
            $query = "Call Applications_GetAll()";
            $this->connection = Connection::GetInstance();
            $result = $this->connection->Execute($query,array(),QueryType::StoredProcedure);
            foreach($result as $row)
            {
                $application = new Application();
                $application->setApplicationId($row["applicationId"]);
                $application->setApplicationDate($row["applicationDate"]);
                $application->setStudent($studentDAO->GetById($row["studentId"])); //devuelve un student
                $application->setJobOffer($jobOfferDAO->SearchJobOffer($row["jobOfferId"])); //devuelve el Job Offer
                $application->setDescription($row["description"]);
                $application->setActive($row["active"]);
                array_push($applicationList, $application);
            }
            return $applicationList;
        }

        public function Remove($id)
        {
            $query = "CALL Applications_Remove(?)";

            $parameters["id"] =  $id;

            $this->connection = Connection::GetInstance();

            $this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);
            
        }

        public function GetStudentApplications($id) //hace una lista de las aplicaciones para este usuario
        {
            $studentDAO = new StudentDAO;
            $jobOfferDAO = new JobOfferDAO;
            $applicationList = array();
            $query = "Call Applications_GetAll()";
            $this->connection = Connection::GetInstance();
            $result = $this->connection->Execute($query,array(),QueryType::StoredProcedure);
            foreach($result as $row)
            {
                if($row["studentId"]==$id){
                    $application = new Application();
                    $application->setApplicationId($row["applicationId"]);
                    $application->setApplicationDate($row["applicationDate"]);
                    $application->setStudent($studentDAO->GetById($row["studentId"])); //devuelve un student
                    $application->setJobOffer($jobOfferDAO->SearchJobOffer($row["jobOfferId"])); //devuelve el Job Offe
                    
                    $application->setDescription($row["description"]);
                    $application->setActive($row["active"]);
                    array_push($applicationList, $application);
                }
            }
            return $applicationList;
        }

        public function ChangeStatus($id) //para dar de baja
        {
            $query = "CALL Applications_ChangeStatus(?,?)";
            $parameters["id"] =  $id;
            $parameters["newSatus"] =0;
            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);
        }

        public function CheckApplicationStatus($id)
        {
            $applicationList=$this->GetAll(); //traigo la company a modificar
            $application = new Application();
            foreach($applicationList as $value) {
                if($value->getApplicationId() == $id) //filtro busqueda
                {
                  $application = $value;  
                }
            }
            return $application->getActive(); //retorna 0 desactvada 1 activada
        }
    }


?>