<?php namespace DAO;

    use DAO\IApplicationDAO as IApplicationDAO;
    use Models\Application as Application;
    use DAO\Connection as Connection;
    use DAO\QueryType as QueryType;

    use DAO\UserDAO as UserDAO;
    use DAO\JobOfferDAO as JobOfferDAO;
    use \Exception as Exception;

    /*use Models\Student as Student;
    use Models\JobOffer as JobOffer;*/

class ApplicationDAO implements IApplicationDAO
    {
        private $connection;
    
        public function Add(Application $application)
        {
                        
            $query = "CALL Applications_Add(?,?,?,?,?,?)";

            
            $parameters["applicationDate"]= $application->getApplicationDate();
            $parameters["studentId"] = $application->getUser()->getUserId();
            $parameters["jobOfferId"] = $application->getJobOffer()->getJobOfferId();
            $parameters["cv"] = $application->getCv();
            $parameters["description"] = $application->getDescription();   
            $parameters["active"] = $application->getActive();
            
            $this->connection = Connection::GetInstance();

            $this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);
        }
        
        public function GetAll()
        {
            $userDAO = new UserDAO;
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
                $application->setUser($userDAO->GetById($row["studentId"])); //devuelve un student
                $application->setJobOffer($jobOfferDAO->SearchJobOffer($row["jobOfferId"])); //devuelve el Job Offer
                $application->setCv($row["cv"]);
                $application->setDescription($row["description"]);
                $application->setActive($row["active"]);
                array_push($applicationList, $application);
            }
            return $applicationList;
        }

        public function addCV($cv){
            try
            {
                $query = "CALL cv_add(?,?);";
                
                $parameters["name"] = $cv->getName();
                $parameters["studentId"]=$_SESSION["loggedUser"]->getUserId();

                $this->connection = Connection::GetInstance();

                $this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);
            }
            catch(Exception $ex){
                throw $ex;
            }
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
            $userDAO = new UserDAO;
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
                    $application->setUser($userDAO->GetById($row["studentId"])); //devuelve un student
                    $application->setJobOffer($jobOfferDAO->SearchJobOffer($row["jobOfferId"])); //devuelve el Job Offe
                    $application->setCv($row["cv"]);
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