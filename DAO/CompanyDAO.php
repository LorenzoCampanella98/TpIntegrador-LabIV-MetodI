<?php namespace DAO;

    use DAO\ICompanyDAO as ICompanyDAO;
    use Models\Company as Company;
    use DAO\Connection as Connection;
    use DAO\QueryType as QueryType;

    class CompanyDAO implements ICompanyDAO
    {
        private $connection;

        public function Add(Company $company)
        {
            $query = "CALL Companies_Add(?,?,?,?,?,?,?)";
            $parameters["creator_user"] = $_SESSION["loggedUser"]->getUserId();
            $parameters["name"]= $company->getName();
            $parameters["cuit"] = $company->getCuit();
            $parameters["company_link"] = $company->getCompanyLink();
            $parameters["aboutUs"] = $company->getAboutUs();
            $parameters["description"] = $company->getDescription();
            $parameters["active"] = $company->getActive();

            $this->connection = Connection::GetInstance();

            $this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);

        }

        public function GetAll()
        {
            $companyList = array();
            $query = "Call Companies_GetAll()";
            $this->connection = Connection::GetInstance();
            $result = $this->connection->Execute($query,array(),QueryType::StoredProcedure);
            foreach($result as $row)
            {
                $company = new Company();
                $company->setCompanyId($row["companyId"]);
                $company->setName($row["name"]);
                $company->setCuit($row["cuit"]);
                $company->setCompanyLink($row["company_link"]);
                $company->setAboutUs($row["aboutUs"]);
                $company->setDescription($row["description"]);
                $company->setActive($row["active"]);
                array_push($companyList, $company);
            }
            return $companyList;
        }

        public function GetById($id)
        {
            $companyList=$this->GetAll(); //traigo la company a modificar
            $company = new Company();
            foreach($companyList as $value) {
                if($value->getCompanyId() == $id) //filtro busqueda
                {
                  $company = $value;
                }
            }
            return $company;
        }

        public function Remove($id)
        {
            $query = "CALL Companies_Remove(?)";

            $parameters["id"] =  $id;

            $this->connection = Connection::GetInstance();

            $this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);
        }

        public function SearchCuit($cuit)
        {
            $aux = false;
            $companyList=$this->GetAll();
            foreach($companyList as $value) {
                if($value->getCuit() == $cuit) //filtro busqueda
                {
                    $aux = true; 
                }
            }
            return $aux;
        }

        public function SearchName($name)
        {
            $aux = false;
            $companyList=$this->GetAll();
            foreach($companyList as $value) {
                if($value->getName() == $name) //filtro busqueda
                {
                    $aux = true; 
                }
            }
            return $aux;
        }

        public function ChangeStatus($id)
        {
            $companyList=$this->GetAll(); //traigo la company a modificar
            $company = new Company();
            foreach($companyList as $value) {
                if($value->getCompanyId() == $id) //filtro busqueda
                {
                  $company = $value;  
                }
            }
            $query = "CALL Companies_ChangeStatus(?,?)";
            $parameters["id"] =  $id;
            if($company->getActive()==0){
                
                $parameters["newSatus"] =1;
            } else {
                $parameters["newSatus"] =0;
            }
            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);
        }

        public function Modify($id,$name,$company_link,$aboutUs,$description,$active)
        {
            $company = $this->GetById($id); //por si alguno de los valores no los modifico tomo los que ya estan y sobreescribo
            if($name==''){
                $name=$company->getName();
            }
            if($company_link=='')
            {
                $company_link=$company->getCompanyLink();
            }
            if($aboutUs=='')
            {
                $aboutUs=$company->getAboutUs();
            }
            if($description=='')
            {
                $description=$company->getDescription();
            }
            $query = "CALL Companies_Modify(?,?,?,?,?,?)";
            $parameters["companyId"] =  $id;
            $parameters["name"]=$name;
            $parameters["company_link"] =  $company_link;
            $parameters["aboutUs"] =  $aboutUs;
            $parameters["description"] =  $description;
            $parameters["active"] =  $active;
            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);
        }

        public function Search($id)
        {
            $companyList=$this->GetAll(); //traigo la company a modificar
            $company = new Company();
            foreach($companyList as $value) {
                if($value->getCompanyId() == $id) //filtro busqueda
                {
                  $company = $value;  
                }
            }
            return $company;
        }

        public function ListFilter($name)
        {
            $list_companies = $this->GetAll();
            $list_filter = array();
            foreach($list_companies as $content)
                 {
                    $cadena_texto = $content->getName();
                    $flag = false;
                    if(stristr($cadena_texto, $name) !== false)
                    {
                        $flag = true;
                    }
                    if($flag==true)
                    { 
                        $company = new Company();
                        $company = $content;
                        array_push($list_filter, $company);
                    } 
                 }
            return $list_filter;
        }

        public function GetByCreatorUserAndName($id,$name)
        {
            $query = "Call Companies_GetAll()";
            $this->connection = Connection::GetInstance();
            $result = $this->connection->Execute($query,array(),QueryType::StoredProcedure); //tengo tods los datos de la BD
            $company = null;
            foreach($result as $row)
            {
                if($row["creator_user"]==$id && $row["name"]==$name)
                {
                    $company = new Company();
                    $company->setCompanyId($row["companyId"]);
                    $company->setName($row["name"]);
                    $company->setCuit($row["cuit"]);
                    $company->setCompanyLink($row["company_link"]);
                    $company->setAboutUs($row["aboutUs"]);
                    $company->setDescription($row["description"]);
                    $company->setActive($row["active"]);
                } 
            }
            return $company;  
        }
    }



?>