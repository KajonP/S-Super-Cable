<?php

class Zone
{
    //------------- Properties
    private $ID_Zone;
    private $ID_Employee;
    private $ID_Company;
    private $AMPHUR_ID;
    private $PROVINCE_ID;
    private const TABLE = "zone";

    //----------- Getters & Setters
    public function getID_Zone(): int
    {
        return $this->ID_Zone;
    }
    public function setID_Zone(int $ID_Zone)
    {
        $this->$ID_Zone = $ID_Zone;
    }
    public function getID_Employee(): string
    {
        return $this->ID_Employee;
    }
    public function setID_Employee(string $ID_Employee)
    {
        $this->$ID_Employee = $ID_Employee;
    }
    public function getID_Company(): string
    {
        return $this->ID_Company;
    }
    public function setID_Company(string $ID_Company)
    {
        $this->$ID_Company = $ID_Company;
    }
    public function getAMPHUR_ID(): int
    {
        return $this->AMPHUR_ID;
    }
    public function setAMPHUR_ID(int $AMPHUR_ID)
    {
        $this->$AMPHUR_ID = $AMPHUR_ID;
    }
    public function getPROVINCE_ID(): int
    {
        return $this->PROVINCE_ID;
    }
    public function setPROVINCE_ID(int $PROVINCE_ID)
    {
        $this->$PROVINCE_ID = $PROVINCE_ID;
    }

    //----------- CRUD
    public static function findAll(): array
    {
        $con = Db::getInstance();
        $query = "SELECT * FROM " . self::TABLE. " inner join Employee on " . self::TABLE.".ID_Employee = Employee.ID_Employee
            inner join PROVINCE on ". self::TABLE.".PROVINCE_ID = PROVINCE.PROVINCE_ID
            left join AMPHUR on ". self::TABLE.".AMPHUR_ID = AMPHUR.AMPHUR_ID";
       
        $stmt = $con->prepare($query);
        $stmt->setFetchMode(PDO::FETCH_CLASS, "Zone");
        $stmt->execute();
        $zoneList = array();
        while ($prod = $stmt->fetch()) {
            $zoneList[$prod->getID_Zone()] = $prod;
        }
        return $zoneList;
    }

    public static function findById(string $ID_Zone): ?Zone
    {
        $con = Db::getInstance();
        $query = "SELECT * FROM " . self::TABLE . " WHERE ID_Zone = '$ID_Zone'";
        // print_r($query);
        $stmt = $con->prepare($query);
        $stmt->setFetchMode(PDO::FETCH_CLASS, "Zone");
        $stmt->execute();
        if ($prod = $stmt->fetch()) {
            return $prod;
        }
        return null;
    }
    # จัดการโซน  ( เพิ่มโซน )
    public function create_zone(array $params)
    {
        $con = Db::getInstance();
        $values = "";
        $columns = "";
        foreach ($params as $prop => $val) {
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
    # แก้ไขโซน
    public function edit_zone(array $params, string $ID_Zone)
    {
        $query = "UPDATE " . self::TABLE . " SET ";
        foreach ($params as $prop => $val) {
            //if (!empty($val)) {
                $query .= " $prop='$val',";
            //}
        }
        $query = substr($query, 0, -1);
        $query .= " WHERE ID_Zone = '" . $ID_Zone . "'";
        //echo $query;
        //exit();
        $con = Db::getInstance();
        if ($con->exec($query)) {
            return array("status" => true);
        } else {

            return array("status" => false);
        }
    }
    # ลบโซน
    public function delete_zone($ID_Zone)
    {
        $query = "DELETE FROM " . self::TABLE . " WHERE ID_Zone = '{$ID_Zone}' ";
        $con = Db::getInstance();
        if ($con->exec($query)) {
            return array("status" => true);
        } else {
            return array("status" => false);
        }
    }
}