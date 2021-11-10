<?php namespace DAO;

    use DAO\IApplicationDAO as IApplicationDAO;
    use Models\Application as Application;
    use DAO\Connection as Connection;
    use DAO\QueryType as QueryType;

class ApplicationDAO implements IApplicationDAO
    {
        private $connection;
        public function Add(Application $application)
        {
            $query = "CALL Applications_Add(?,?,?,?,?)";
            $parameters["applicationDate"]= $application->getApplicationDate();
            $parameters["studentId"] = $application->getStudentId();
            $parameters["jobOfferId"] = $application->getJobOfferId();
            $parameters["description"] = $application->getDescription();
            $parameters["active"] = $application->getActive();
            
            $this->connection = Connection::GetInstance();

            $this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);
        }
        
        public function GetAll()
        {
            $applicationList = array();
            $query = "Call Applications_GetAll()";
            $this->connection = Connection::GetInstance();
            $result = $this->connection->Execute($query,array(),QueryType::StoredProcedure);
            foreach($result as $row)
            {
                $application = new Application();
                $application->setApplicationId($row["applicationId"]);
                $application->setApplicationDate($row["applicationDate"]);
                $application->setStudentId($row["studentId"]);
                $application->setJobOfferId($row["jobOfferId"]);
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

        public function GetStudentApplications($id)
        {
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
                    $application->setStudentId($row["studentId"]);
                    $application->setJobOfferId($row["jobOfferId"]);
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