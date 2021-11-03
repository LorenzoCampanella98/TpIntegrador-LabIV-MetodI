<?php namespace DAO;

    use DAO\IStudentRegisteredDAO as IStudentRegisteredDAO;
    use Models\StudentRegistered as StudentRegistered;
    use DAO\Connection as Connection;
    use DAO\QueryType as QueryType;

    class StudentRegisteredDAO implements IStudentRegisteredDAO{
        private $connection;
        private $tableName ="studentRegistered";

        public function GenerateAdmin($message = "admin")
        {
            $student = new StudentRegistered();
            $student->setStudentId(0);
            $student->setName($message);
            $student->setSurname($message);
            $student->setFileNumber(0);
            $student->setPassword(0);
            $student->setPostulated(0);
            return $student;

        }

        public function Add( StudentRegistered $student)
        {
            $query = "CALL studentRegistered_Add(?,?,?,?,?,?,?)";
            //$parameters["studentId"] =  $student->getStudentId();
            $parameters["studentId"] =  $this->GetNextId();
            $parameters["fileNumber"] = $student->getFileNumber();
            $parameters["name"] = $student->getName();
            $parameters["surname"] = $student->getSurname();
            $parameters["password"] = $student->getPassword();
            $parameters["email"] = $student->getEmail();
            $parameters["postulated"] = $student->getPostulated();

            $this->connection = Connection::GetInstance();

            $this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);
        }

        public function GetAll()
        {
            $studentList = array();
            $query = "Call StudentRegistered_GetAll()";
            $this->connection = Connection::GetInstance();
            $result = $this->connection->Execute($query,array(),QueryType::StoredProcedure);
            foreach($result as $row)
            {
                $student = new StudentRegistered();
                $student->setStudentId($row["studentId"]);
                $student->setFileNumber($row["fileNumber"]);
                $student->setName($row["name"]);
                $student->setSurname($row["surname"]);
                $student->setPassword($row["password"]);
                $student->setEmail($row["email"]);
                $student->setPostulated($row["postulated"]);
                array_push($studentList, $student);
            }
            return $studentList;
        }

         function GetById($id)
        {
            
        }

        public function GetByEmailAndPasswordBD($email,$password)
        {
            $query = "Call StudentRegistered_GetAll()";
            $this->connection = Connection::GetInstance();
            $result = $this->connection->Execute($query,array(),QueryType::StoredProcedure); //tengo tods los datos de la BD
            $student = null;
            foreach($result as $row)
            {
                if($row["email"]==$email && $row["password"==$password])
                {
                    $student = new StudentRegistered();
                    $student->setStudentId($row["studentId"]);
                    $student->setFileNumber($row["fileNumber"]);
                    $student->setName($row["name"]);
                    $student->setSurname($row["surname"]);
                    $student->setPassword($row["password"]);
                    $student->setEmail($row["email"]);
                    $student->setPostulated($row["postulated"]);
                } 
            }
            return $student;
        }
        
        
        public function SearchByEmailApi($email)
        {
            $flag = 0;
            $data = $this->RetrieveDataFromApi();
            foreach($data as $content)
            {
                if($content["email"]==$email)
                {
                    if($content["active"]==true)
                    {
                        $flag=1;
                    }                    
                }
            }
            return $flag;
        }

        function Remove($id)
        {
            $query = "CALL StudentRegistered_Remove(?)";

            $parameters["id"] =  $id;

            $this->connection = Connection::GetInstance();

            $this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);
        }

        private function RetrieveDataFromApi()
        {
            $ch = curl_init();
            $url = 'https://utn-students-api.herokuapp.com/api/Student';
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
            return $data;
        }

        

        public function register($email,$password) //cambiar , tiene que ser email o otra cosa
        {
            $data = $this->RetrieveDataFromApi();
            //var_dump($data);
            foreach($data as $content)
            {
                if($content["email"]==$email)
                {
                    if($content["active"]==true)
                    {
                        $student = new StudentRegistered();
                        $student->setStudentId($content["studentId"]);
                        $student->setFileNumber($content["fileNumber"]);
                        $student->setName($content["firstName"]);
                        $student->setSurname($content["lastName"]);
                        $student->setPassword($password);
                        $student->setEmail($content["email"]);
                        $student->setPostulated(0);
                        $this->Add($student);
                    }
                    
                }
            }
        }

        private function GetNextId() //para que el id aumente a medida que agrego cellphones
        {
             // CAMBIAR -> ES TODO EL CODIGO DE GETALL SOLO PQ NECESITO EL STUDENT LIST!!!
            $studentList = array();
            $query = "Call StudentRegistered_GetAll()";
            $this->connection = Connection::GetInstance();
            $result = $this->connection->Execute($query,array(),QueryType::StoredProcedure);
            foreach($result as $row)
            {
                $student = new StudentRegistered();
                $student->setStudentId($row["studentId"]);
                $student->setFileNumber($row["fileNumber"]);
                $student->setName($row["name"]);
                $student->setSurname($row["surname"]);
                $student->setPassword($row["password"]);
                $student->setEmail($row["email"]);
                $student->setPostulated($row["postulated"]);
                array_push($studentList, $student);
            }

            $id = 0;
            foreach($studentList as $student)
            {
                $id = ($student->getStudentId() > $id) ? $student->getStudentId() : $id;
            }
            return $id + 1;
        }

        public function ChangePostulated($id)
        {
            $studentList=$this->GetAll(); //traigo la company a modificar
            $student = new StudentRegistered();
            foreach($studentList as $value) {
                if($value->getStudentId() == $id) //filtro busqueda
                {
                  $student = $value;  
                }
            }
            $query = "CALL StudentRegistered_ChangePostulated(?,?)";
            $parameters["id"] =  $id;
            if($student->getPostulated()==0){
                $parameters["newSatus"] =1;
            } else {
                $parameters["newSatus"] =0;
            }
            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);
        }



    }


?>