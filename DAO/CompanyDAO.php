<?php namespace DAO;

    use DAO\ICompanyDAO as ICompanyDAO;
    use Models\Company as Company;

    class CompanyDAO
    {
        private $companyList = array();
        private $fileName = ROOT."Data/Company.json";

        public function Add(Company $company)
        {
            $this->RetrieveData();
            $company->setCompanyId($this->GetNextId());
            $company->setActive(true);
            array_push($this->companyList, $company);
            $this->SaveData();
        }

        public function GetAll()
        {
            $this->RetrieveData();
            return $this->companyList;
        }

        public function ChangeStatus($id)
        {        
            $this->RetrieveData();
            foreach($this->companyList as $value) {//busco por id
                if($value->getCompanyId() == $id)
                {
                    if($value->getActive()==true){
                        $value->setActive(false); //solo cambia es estatus a false
                    } else {
                        $value->setActive(true); //solo cambia es estatus a true
                    } 
                }
            }
            $this->SaveData();
            //------- ESTO ELIMINA DIRECTAMENTE LA COMPANIA ------
            /*$this->RetrieveData(); 
            $this->companyList = array_filter($this->companyList, function($company) use($id){                
                return $company->getCompanyId() != $id;
            });
            $this->SaveData();*/
        }

        public function Modify($id, $name, $address, $active) //PARA modificar
        {
            $this->RetrieveData();
            foreach($this->companyList as $value) {
                if($value->getCompanyId() == $id)
                {
                    $value->setName($name);
                    $value->setAddress($address);
                    if($active == "1"){ //porque desde el form solo puedo enviar string no boolean
                        $value->setActive(true);    
                    } else {
                        $value->setActive(false);
                    }
                }
            }
            $this->SaveData();
        }

        public function Search($name) //por nombre
        {
            $aux = new Company();
            $this->RetrieveData();
            foreach($this->companyList as $value) {
                if($value->getName() == $name) //filtro busqueda
                {
                    $aux = $value; 
                }
            }
            return $aux;
        }

        private function RetrieveData()
        {
             $this->companyList = array();
             if(file_exists($this->fileName))
             {
                 $jsonToDecode = file_get_contents($this->fileName);
                 $contentArray = ($jsonToDecode) ? json_decode($jsonToDecode, true) : array();
                 foreach($contentArray as $content)
                 {
                    $company = new Company();

                    $company->setCompanyId($content["companyId"]);
                    $company->setCuit($content["cuit"]);
                    $company->setAddress($content["address"]);
                    $company->setName($content["name"]);
                    $company->setActive($content["active"]);
                    array_push($this->companyList, $company);
                 }
             }
        }

        private function SaveData()
        {
            $arrayToEncode = array();
            foreach($this->companyList as $company)
            {
                $valuesArray = array();
                $valuesArray["companyId"]=$company->getCompanyId();
                $valuesArray["cuit"]=$company->getCuit();
                $valuesArray["address"]=$company->getAddress();
                $valuesArray["name"]=$company->getName();
                $valuesArray["active"]=$company->getActive();
                array_push($arrayToEncode, $valuesArray);
            }
            $fileContent = json_encode($arrayToEncode, JSON_PRETTY_PRINT);
            file_put_contents($this->fileName, $fileContent);
        }

        private function GetNextId() //para que el id aumente a medida que agrego cellphones
        {
            $id = 0;
            foreach($this->companyList as $company)
            {
                $id = ($company->getCompanyId() > $id) ? $company->getCompanyId() : $id;
            }
            return $id + 1;
        }

        public function GetById($id)
        {
            $company = null;
            $this->RetrieveData();
            $companies = array_filter($this->companyList, function($company) use($id){
                return $company->getCompanyId() == $id;
            });
            $companies = array_values($companies); //Reordering array indexes
            return (count($companies) > 0) ? $company[0] : null;
        }

        public function SearchCuit($cuit)
        {
            $aux = false;
            $this->RetrieveData();
            foreach($this->companyList as $value) {
                if($value->getCuit() == $cuit) //filtro busqueda
                {
                    $aux = true; 
                }
            }
            return $aux;
        }

        public function RetrieveDataFilter($name)
        {
            $aux_filtrado= array();
            //$tam = strlen($name);
            if(file_exists($this->fileName))
             {
                 $jsonToDecode = file_get_contents($this->fileName);
                 $contentArray = ($jsonToDecode) ? json_decode($jsonToDecode, true) : array();
                 foreach($contentArray as $content)
                 {
                    $nombre_aux = $content['name']; 
                    if(strlen($name) <= strlen($nombre_aux))
                    {
                       $flag = false;
                    for ($i=0; $i < strlen($name); $i++) { 
                        if($nombre_aux[$i]==$name[$i]){
                            $flag=true;
                        } else {
                            $flag = false;
                        }
                    }
                    if($flag==true)
                    { 
                        $company = new Company();
                        $company->setCompanyId($content["companyId"]);
                        $company->setCuit($content["cuit"]);
                        $company->setAddress($content["address"]);
                        $company->setName($content["name"]);
                        $company->setActive($content["active"]);
                        array_push($aux_filtrado, $company);
                    } 
                    }
                 }
             }
            return $aux_filtrado;
        }
    }
?>