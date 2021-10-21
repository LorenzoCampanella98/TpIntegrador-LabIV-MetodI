<?php namespace DAO;

    use DAO\IJobPositionDAO as IJobPositionDAO;
    use Models\JobPosition as JobPosition;

    class JobPositionDAO implements IJobPositionDAO
    {
        private $jobPositionList = array();
        private $fileName = ROOT."Data/JobPosition.json";

        public function Add(JobPosition $jobPosition)
        {
            $this->RetrieveData();
            $jobPosition->setJobPositionId($this->GetNextId());
            array_push($this->jobPositionList, $jobPosition);
            $this->SaveData();
        }

        public function GetAll()
        {
            $this->RetrieveData();
            return $this->jobPositionList;
        }

        public function Remove($id)
        {            
            $this->RetrieveData();
            $this->jobPositionList = array_filter($this->jobPositionList, function($jobPosition) use($id){                
                return $jobPosition->getJobPositionId() != $id;
            });
            $this->SaveData();
        }

        private function RetrieveData()
        {
            $this->jobPositionList = array();
            if(file_exists($this->fileName))
            {
                $jsonToDecode = file_get_contents($this->fileName);
                $contentArray = ($jsonToDecode) ? json_decode($jsonToDecode, true) : array();
                foreach($contentArray as $content)
                {
                    $jobPosition = new JobPosition();

                    $jobPosition->setJobPositionId($content["jobPositionId"]);
                    $jobPosition->setCareerId($content["careerId"]);
                    $jobPosition->setDescription($content["description"]);

                    array_push($this->jobPositionList, $jobPosition);
                }
            }
        }

        private function SaveData()
        {
            $arrayToEncode = array();
            foreach($this->jobPositionList as $jobPosition)
            {
                $valuesArray = array();

                $valuesArray["jobPositionId"]=$jobPosition->getJobPositionId();
                $valuesArray["careerId"]=$jobPosition->getCareerId();
                $valuesArray["description"]=$jobPosition->getDescription();
                array_push($arrayToEncode, $valuesArray);
            }
            $fileContent = json_encode($arrayToEncode, JSON_PRETTY_PRINT);
            file_put_contents($this->fileName, $fileContent);
        }

        private function GetNextId() //para que el id aumente a medida que agrego cellphones
        {
            $id = 0;
            foreach($this->jobPositionList as $jobPosition)
            {
                $id = ($jobPosition->getStudentId() > $id) ? $jobPosition->getStudentId() : $id;
            }
            return $id + 1;
        }

        public function RetrieveDataFromAPI()
        {
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
            $this->studentList = $data;
            $fileContent = json_encode($data, JSON_PRETTY_PRINT);
            file_put_contents($this->fileName, $fileContent);
        }

    }

?>