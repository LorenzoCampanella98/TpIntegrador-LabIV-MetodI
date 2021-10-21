<?php namespace DAO;

    use DAO\ICareerDAO as ICareerDAO;
    use Models\Career as Career;
    use DAO\Connection as Connection;
    use DAO\QueryType as QueryType;

    class CareerDAO implements ICareerDAO
    {
        private $connection;
        private $tableName ="careers";

        public function Add(Career $career)
        {
            $query = "CALL Careers_Add(?, ?, ?)";

            $parameters["careerId"] =  $career->getCareerId();
            $parameters["description"] = $career->getDescription();
            $parameters["active"] = $career->getActive();

            $this->connection = Connection::GetInstance();

            $this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);
        }

        public function GetAll()
        {
            $careerList = array();
            $query = "Call Careers_GetAll()";
            $this->connection = Connection::GetInstance();
            $result = $this->connection->Execute($query,array(),QueryType::StoredProcedure);
            foreach($result as $row)
            {
                $career = new Career();
                $career->setCareerId($row["careerId"]);
                $career->setDescription($row["description"]);
                $career->setActive($row["active"]);
                array_push($careerList, $career);
            }
            return $careerList;
        }
        public function GetById($id)
        {
            $career = null;
            $query = "CALL Careers_GetById(?)";
            $parameters["id"]=$id;
            $results = $this->connection->Execute($query, $parameters, QueryType::StoredProcedure);
            foreach($results as $row)
            {
                $career = new Career();
                $career->setCareerId($row["careerId"]);
                $career->setDescription($row["description"]);
                $career->setActive($row["active"]);
            }
            return $career;

        }

        public function RetrieveDataFromApi()
        {
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
            return $data;
        }

        public function LoadBD() //recorro arreglo proporcionado por retrieve data from api y cargo cada valor
        {
            $data = $this->RetrieveDataFromApi();
            var_dump($data);
            foreach($data as $content)
            {
                $career = new Career();
                $career->setCareerId($content["careerId"]);
                $career->setDescription($content["description"]);
                if($content["active"]==true){
                    $career->setActive(1); //1 active
                } else {
                    $career->setActive(0); //0 non active
                }
                
                //var_dump($career->setActive($content["active"]));
                $this->Add($career);
                var_dump($career);
            }
        }

    }
?>