<?php

class Award
{
    //------------- Properties
    private $ID_Award;
    private $Tittle_Award;
    private $Picture_Award;
    private $Date_Award;
    private $ID_Employee;
    private $fullname_employee;
    private const TABLE = "award";


    //----------- Getters & Setters
    
    // ---- id Award
    public function getID_Award(): int
    {
        return $this->ID_Award;
    }

    public function setID_Award(int $ID_Award)
    {
        $this->getID_Award = $getID_Award;
    }

    // --- title Award
    public function getTittle_Award(): string 
    {
        return $this->Tittle_Award;
    }

    public function setTittle_Award(string $Tittle_Award)
    {
        $this->getTittle_Award = $getTittle_Award;
    }

    // --- picture Award
    public function getPicture_Award(): string 
    {
        return $this->Picture_Award;
    }

    public function setPicture_Award(string $Picture_Award)
    {
        $this->getPicture_Award = $getPicture_Award;
    }

    // --- date Award
    public function getDate_Award(): string 
    {
        return $this->Date_Award;
    }

    public function setDate_Award(string $Date_Award)
    {
        $this->getDate_Award = $getDate_Award;
    }

    public function getID_Employee() : string
    {
        return $this->ID_Employee;
    }

    public function setID_Employee(string $ID_Employee)
    {
        $this->getID_Employee = $ID_Employee;
    }

    public function getFullname_employee() : string
    {
        return $this->fullname_employee;
    }

    public function setFullname_employee(string $fullname_employee)
    {
        $this->getFullname_employee = $fullname_employee;
    }



    public static function fetchAll(): array
    {
        $con = Db::getInstance();
        $query = "SELECT " . self::TABLE . ".*,employee.ID_Employee, concat(employee.Name_Employee, ' ',employee.Surname_Employee) as fullname_employee  FROM " . self::TABLE . " 
        LEFT JOIN employee ON " . self::TABLE . ".ID_Employee = employee.ID_Employee  " ;
        
        $stmt = $con->prepare($query);
        $stmt->setFetchMode(PDO::FETCH_CLASS, "award");
        $stmt->execute();
        $list = array();
        while ($prod = $stmt->fetch()) {
            $list[$prod->getID_Award()] = $prod;
        }
        return $list;

    }

    public static function findAward_byID($ID_Award): ?Award
    {
        $con = Db::getInstance();
        $query = "SELECT * FROM " . self::TABLE . " WHERE ID_Award = '$ID_Award'";
        $stmt = $con->prepare($query);
        $stmt->setFetchMode(PDO::FETCH_CLASS, "award");
        $stmt->execute();
        if ($prod = $stmt->fetch()) {
            return $prod;
        }
        return null;
    }

    public static function generateIDAward($title_award)
    {
        $awardid = self::geneateDateTimemd() ;
        return  md5(uniqid($awardid, true)) ;
    }

    public static function geneateDateTimemd()
    {
        date_default_timezone_set("Asia/Bangkok");
        return Date("YmdHis") ;
    }

    public static function geneateDateTime()
    {
        date_default_timezone_set("Asia/Bangkok");
        return date("Y-m-d H:i:s") ;
    }

    public static function generatePictureFilename($imagename, $titleaward)
    {
        $award_picture_filename = "$imagename"."$titleaward".self::geneateDateTimemd() ;
        return  md5(uniqid($award_picture_filename, true)) ;
    }


    //  save data into database 

    public static function create_award($awardModel)
    {
        $con = Db::getInstance();
        $values = "";
        $columns = "";
        foreach ($awardModel as $prop => $val) {
            # ถ้า column แรกไม่ต้องเติมลูกน้ำ คอลัมน์อื่นเติมลูกน้ำ
            $columns = empty($columns) ? $columns .= $prop : $columns .= "," . $prop;
            $values .= "'$val',";
        }
        $values = substr($values, 0, -1);
        $query = "INSERT INTO " . self::TABLE . "({$columns}) VALUES ($values)";

        # execute query
        if ($con->exec($query)) {
            return array("status" => true);
        } else {
            $message = "มีบางอย่างผิดพลาด , กรุณาตรวจสอบข้อมูล ";
            return array("status" => false, "message" => $message);
        }
        
    }

    public static function update_award($awardUpdateModel)
    {   
        $ID_Award = $awardUpdateModel['ID_Award'];
        $query = "UPDATE " . self::TABLE . " SET ";
        foreach ($awardUpdateModel as $prop => $val) {
            if($val != '') {
                $query .= " $prop='$val',";
            }
        }
        $query = substr($query, 0, -1);
        $query .= " WHERE ID_Award = '" . $ID_Award . "'";
        
        $con = Db::getInstance();
        if ($con->exec($query)) {
            return array("status" => true);
        } else {

            return array("status" => false);
        }
    }

    public static function delete_award($ID_Award)
    {
        $query = "DELETE FROM " . self::TABLE . " WHERE ID_Award = '{$ID_Award}' ";
        $con = Db::getInstance();
        if ($con->exec($query)) {
            return array("status" => true);
        } else {
            return array("status" => false);
        }
    }

}