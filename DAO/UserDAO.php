<?php namespace DAO;

    use DAO\IUserDAO as IUserDAO;
    use Models\User as User;
    use DAO\Connection as Connection;
    use DAO\QueryType as QueryType;

    class UserDAO implements IUserDAO{
        private $connection;

        public function Add( User $user)
        {
            $query = "CALL studentRegistered_Add(?,?,?,?,?,?,?)";
            $parameters["fileNumber"] = $user->getFileNumber();
            $parameters["name"] = $user->getName();
            $parameters["surname"] = $user->getSurname();
            $parameters["password"] = $user->getPassword();
            $parameters["email"] = $user->getEmail();
            $parameters["postulated"] = $user->getPostulated();
            $parameters["typeStudentId"] = $user->getTypeUserId();
            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);
        }

        public function GetAll()
        {
            $userList = array();
            $query = "Call StudentRegistered_GetAll()";
            $this->connection = Connection::GetInstance();
            $result = $this->connection->Execute($query,array(),QueryType::StoredProcedure);
            foreach($result as $row)
            {
                $user = new User();
                $user->setUserId($row["studentId"]);
                $user->setFileNumber($row["fileNumber"]);
                $user->setName($row["name"]);
                $user->setSurname($row["surname"]);
                $user->setPassword($row["password"]);
                $user->setEmail($row["email"]);
                $user->setPostulated($row["postulated"]);
                $user->setTypeUserId($row["typeStudentId"]);
                array_push($userList, $user);
            }
            return $userList;
        }

         function GetById($id)
        {
            $userList=$this->GetAll(); //traigo la company a modificar
            $user = new User();
            foreach($userList as $value) {
                if($value->getUserId() == $id) //filtro busqueda
                {
                  $user = $value;
                }
            }
            return $user;
        }

        private function CheckByEmailBD($email)
        {
            $userList=$this->GetAll();
            $aux=0;
            foreach ($userList as $user)
            {
                if($user->getEmail()==$email)
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
            $user = null;
            foreach($result as $row)
            {
                if($row["email"]==$email && $row["password"]==$password)
                {
                    $user = new User();
                    $user->setUserId($row["studentId"]);
                    $user->setFileNumber($row["fileNumber"]);
                    $user->setName($row["name"]);
                    $user->setSurname($row["surname"]);
                    $user->setPassword($row["password"]);
                    $user->setEmail($row["email"]);
                    $user->setPostulated($row["postulated"]);
                    $user->setTypeUserId($row["typeStudentId"]);
                } 
            }
            return $user;
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
            $url = 'https://utn-students-api2.herokuapp.com/api/Student';
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
                        $user = new User();
                        $user->setFileNumber($content["fileNumber"]);
                        $user->setName($content["firstName"]);
                        $user->setSurname($content["lastName"]);
                        $user->setPassword($password);
                        $user->setEmail($content["email"]);
                        $user->setPostulated(0);
                        $user->setTypeUserId(1); //1 es estudiante , 2 es admin
                        if($this->CheckByEmailBD($email)==0)
                        { 
                            $this->Add($user);
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

        public function registerUserCompany($email,$password,$name)
        {
            $user = new User();
            $user->setEmail($email);
            $user->setPassword($password);
            $user->setTypeUserId(3);
            $user->setFileNumber("0");
            $user->setName($name);
            $user->setSurname("0");
            $user->setPostulated(0);
            $this->Add($user);
            $message = "REGISTADO: ".$email." ---  como USER COMPANY -- INTENTA LOGUEARTE ----";
            return $message;
        }

        public function addAdmin($name,$fileNumber,$surname,$password,$email)
        {
            $user = new User();
            $user->setFileNumber($fileNumber);
            $user->setName($name);
            $user->setSurname($surname);
            $user->setPassword($password);
            $user->setEmail($email);
            $user->setPostulated(0);
            $user->setTypeUserId(2); //1 es estudiante , 2 es admin
            $this->Add($user);
        }

        
        public function ChangePostulated($id)
        {
            $userList=$this->GetAll(); //traigo la company a modificar
            $user = new User();
            foreach($userList as $value) {
                if($value->getUserId() == $id) //filtro busqueda
                {
                  $user = $value;  
                }
            }
            $query = "CALL StudentRegistered_ChangePostulated(?,?)";
            $parameters["id"] =  $id;
            if($user->getPostulated()==0){
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
            $url = 'https://utn-students-api2.herokuapp.com/api/Career';
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