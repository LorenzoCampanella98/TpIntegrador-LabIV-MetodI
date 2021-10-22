<?php namespace DAO;

    use DAO\IStudentDAO as IStudentDAO;
    use Models\Student as Student;

    class StudentDAO implements IStudentDAO
    {
        private $studentList = array();

        private $fileName = ROOT."Data/Student.json";

        public function RetrieveDataFromAPI()
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
            $this->studentList = $data;
            $fileContent = json_encode($data, JSON_PRETTY_PRINT);
            file_put_contents($this->fileName, $fileContent);
        }

        public function Add(Student $student) 
        {
            $this->RetrieveData();
            $student->setStudentId($this->GetNextId());
            array_push($this->studentList, $student);
            $this->SaveData();
        }

        public function GetAll()
        {
            $this->RetrieveData();
            return $this->studentList;
        }

        public function Remove($id)
        {            
            $this->RetrieveData();
            $this->studentList = array_filter($this->studentList, function($student) use($id){                
                return $student->getStudentId() != $id;
            });
            $this->SaveData();
        }

        public function GenerateAdmin($message = "admin")
        {
            $student = new Student();
            $student->setStudentId(0);
            $student->setCareerId(0);
            $student->setFirstName($message);
            $student->setLastName ($message);
            $student->setDni (0);
            $student->setFilenumber(0);
            $student->setGender (0);
            $student->setBirthDate(0);
            $student->setEmail($message);
            $student->setPhoneNumber(0);
            $student->setActive(true);
            return $student;        
        }
        //SOLO PARA JSON - PREEVIO A API
        private function RetrieveData()
        {
            $this->studentList = array();
            if(file_exists($this->fileName))
            {
                $jsonToDecode = file_get_contents($this->fileName);
                $contentArray = ($jsonToDecode) ? json_decode($jsonToDecode, true) : array();
                foreach($contentArray as $content)
                {
                    $student = new Student();
                    $student->setStudentId($content["studentId"]);
                    $student->setCareerId($content["careerId"]);
                    $student->setFirstName($content["firstName"]);
                    $student->setLastName ($content["lastName"]);
                    $student->setDni ($content["dni"]);
                    $student->setFilenumber($content["fileNumber"]);
                    $student->setGender ($content["gender"]);
                    $student->setBirthDate($content["birthDate"]);
                    $student->setEmail($content["email"]);
                    $student->setPhoneNumber($content["phoneNumber"]);
                    $student->setActive($content["active"]);
                    array_push($this->studentList, $student);
                }
            }
        }
        private function SaveData()
        {
            $arrayToEncode = array();
            foreach($this->studentList as $student)
            {
                $valuesArray = array();
                $valuesArray["studentId"]=$student->getStudentId();
                $valuesArray["careerId"]=$student->getCareerId();
                $valuesArray["firstName"]=$student->getFirstName();
                $valuesArray["lastName"]=$student->getLastName();
                $valuesArray["dni"]=$student->getDni();
                $valuesArray["fileNumber"]=$student->getFilenumber();
                $valuesArray["gender"]=$student->getGender();
                $valuesArray["birthDate"]=$student->getBirthDate();
                $valuesArray["email"]=$student->getEmail();
                $valuesArray["phoneNumber"]=$student->getPhoneNumber();
                $valuesArray["active"]=$student->getActive();
                array_push($arrayToEncode, $valuesArray);
            }
            $fileContent = json_encode($arrayToEncode, JSON_PRETTY_PRINT);
            file_put_contents($this->fileName, $fileContent);
        }

        private function GetNextId() //para que el id aumente a medida que agrego cellphones
        {
            $id = 0;
            foreach($this->studentList as $student)
            {
                $id = ($student->getStudentId() > $id) ? $student->getStudentId() : $id;
            }
            return $id + 1;
        }

        public function GetById($id)
        {
            $student = null;
            $this->RetrieveData();
            $students = array_filter($this->studentList, function($student) use($id){
                return $student->getStudentId() == $id;
            });
            $students = array_values($students); //Reordering array indexes
            return (count($students) > 0) ? $student[0] : null;
        }

        public function GetByEmail($email)
        {
            $student = null;
            $this->RetrieveData();
            foreach($this->studentList as $value) {//busco por id
                if($value->getEmail() == $email)
                {
                    $student = $value;
                }
            }
            return $student;
        }

    }
?>