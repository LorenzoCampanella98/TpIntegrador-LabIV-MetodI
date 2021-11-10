<?php namespace DAO;

    use DAO\IStudentDAO as IStudentDAO;
    use Models\Student as Student;
    use DAO\Connection as Connection;
    use DAO\QueryType as QueryType;

    class StudentDAO implements IStudentDAO{
        private $connection;

        public function Add( Student $student)
        {
            $query = "CALL studentRegistered_Add(?,?,?,?,?,?,?)";
            $parameters["fileNumber"] = $student->getFileNumber();
            $parameters["name"] = $student->getName();
            $parameters["surname"] = $student->getSurname();
            $parameters["password"] = $student->getPassword();
            $parameters["email"] = $student->getEmail();
            $parameters["postulated"] = $student->getPostulated();
            $parameters["typeStudentId"] = $student->getTypeStudentId();
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
                $student = new Student();
                $student->setStudentId($row["studentId"]);
                $student->setFileNumber($row["fileNumber"]);
                $student->setName($row["name"]);
                $student->setSurname($row["surname"]);
                $student->setPassword($row["password"]);
                $student->setEmail($row["email"]);
                $student->setPostulated($row["postulated"]);
                $student->setTypeStudentId($row["typeStudentId"]);
                array_push($studentList, $student);
            }
            return $studentList;
        }

         function GetById($id)
        {
            $studentList=$this->GetAll(); //traigo la company a modificar
            $student = new Student();
            foreach($studentList as $value) {
                if($value->getStudentId() == $id) //filtro busqueda
                {
                  $student = $value;
                }
            }
            return $student;
        }

        private function CheckByEmailBD($email)
        {
            $studentList=$this->GetAll();
            $aux=0;
            foreach ($studentList as $student)
            {
                if($student->getEmail()==$email)
                {
                    $aux=1; //1 es porque lo
                }
            }
            return $aux;
        }

        public function GetByEmailAndPasswordBD($email,$password)
        {
            $query = "Call StudentRegistered_GetAll()";
            $this->connection = Connection::GetInstance();
            $result = $this->connection->Execute($query,array(),QueryType::StoredProcedure); //tengo tods los datos de la BD
            $student = null;
            foreach($result as $row)
            {
                if($row["email"]==$email && $row["password"]==$password)
                {
                    $student = new Student();
                    $student->setStudentId($row["studentId"]);
                    $student->setFileNumber($row["fileNumber"]);
                    $student->setName($row["name"]);
                    $student->setSurname($row["surname"]);
                    $student->setPassword($row["password"]);
                    $student->setEmail($row["email"]);
                    $student->setPostulated($row["postulated"]);
                    $student->setTypeStudentId($row["typeStudentId"]);
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
            $message=null;
            $data = $this->RetrieveDataFromApi();
            foreach($data as $content)
            {
                if($content["email"]==$email)
                {
                    if($content["active"]==true)
                    {
                        $student = new Student();
                        $student->setFileNumber($content["fileNumber"]);
                        $student->setName($content["firstName"]);
                        $student->setSurname($content["lastName"]);
                        $student->setPassword($password);
                        $student->setEmail($content["email"]);
                        $student->setPostulated(0);
                        $student->setTypeStudentId(1); //1 es estudiante , 2 es admin
                        if($this->CheckByEmailBD($email)==0)
                        { 
                            $this->Add($student);
                            $message = "REGISTADO: ".$email." --- INTENTA LOGUEARTE ----";
                        } else {
                            $message = $email." ---- YA ESTA REGISTRADO";
                        }  
                    } else {
                        $message = $email." ---- SE ENCUENTRA DADO DE BAJA";
                    }
                }
            }
            return $message;
        }

        public function addAdmin($name,$fileNumber,$surname,$password,$email)
        {
            $student = new Student();
            $student->setFileNumber($fileNumber);
            $student->setName($name);
            $student->setSurname($surname);
            $student->setPassword($password);
            $student->setEmail($email);
            $student->setPostulated(0);
            $student->setTypeStudentId(2); //1 es estudiante , 2 es admin
            $this->Add($student);
        }

        
        public function ChangePostulated($id)
        {
            $studentList=$this->GetAll(); //traigo la company a modificar
            $student = new Student();
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

        public function checkConnectionAppi() //publica porque la uso para el el loguin si no esta conectada no entra nadie
        {
            $flag=false;
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
                $flag=false;
            } else { 
                $flag=true;
            }
            curl_close($ch);
            return $flag;
        }

    }


?>