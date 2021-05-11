<?php

class Sales
{
    //------------- Properties
    private $ID_Excel;
    private $Date_Sales;
    private $ID_Company;
    private $Name_Company;
    private $ID_Employee;
    private $Result_Sales;
    private const TABLE = "sales";

    //----------- Getters & Setters
    public function getID_Excel(): int
    {
        return $this->ID_Excel;
    }

    public function setID_Excel(int $ID_Excel)
    {
        $this->ID_Excel = $ID_Excel;
    }

    public function getDate_Sales(): string
    {
        return $this->Date_Sales;
    }

    public function setDate_Sales(string $Date_Sales)
    {
        $this->Date_Sales = $Date_Sales;
    }

    public function getID_Company(): int
    {
        return $this->ID_Company;
    }

    public function setID_Company(int $ID_Company)
    {
        $this->ID_Company = $ID_Company;
    }

    public function getName_Company(): string
    {
        return $this->Name_Company;
    }

    public function setName_Company(string $Name_Company)
    {
        $this->Name_Company;
    }

    public function getName_Employee(): string
    {
        return $this->Name_Employee;
    }

    public function setName_Employee(string $Name_Employee)
    {
        $this->Name_Employee;
    }

    public function getID_Employee(): string
    {
        return $this->ID_Employee;
    }

    public function setID_Employee(int $ID_Employee)
    {
        $this->ID_Employee = $ID_Employee;
    }

    public function getResult_Sales(): float
    {
        return $this->Result_Sales;
    }

    public function setResult_Sales(float $Result_Sales)
    {
        $this->Result_Sales = $Result_Sales;
    }

    //----------- CRUD
    public static function findAll(): array
    {
        $con = Db::getInstance();
        //case: จัดการยอดขายเปลี่ยนไอดีบริษัทเป็นชื่อบริษัทเปลี่ยนไอดีพนักงานเป็นชื่อพนักงาน
        $query = "SELECT " . self::TABLE . ".* ,company.Name_Company,employee.Name_Employee  FROM " . self::TABLE . " 
        join company on " . self::TABLE . ".ID_Company=company.ID_Company 
        join employee on " . self::TABLE . ".ID_Employee=employee.ID_Employee 
         ";
        $stmt = $con->prepare($query);
        $stmt->setFetchMode(PDO::FETCH_CLASS, "Sales");
        $stmt->execute();
        $salesList = array();
        while ($prod = $stmt->fetch()) {
            $salesList[$prod->getID_Excel()] = $prod;
        }
        return $salesList;
    }

    public static function findById(int $ID_Excel): ?Sales
    {
        $con = Db::getInstance();
        $query = "SELECT * FROM " . self::TABLE . " WHERE ID_Excel = '$ID_Excel'";
        $stmt = $con->prepare($query);
        $stmt->setFetchMode(PDO::FETCH_CLASS, "Sales");
        $stmt->execute();
        if ($prod = $stmt->fetch()) {
            return $prod;
        }
        return null;
    }

    # จัดการยอดขาย  ( เพิ่มยอดขาย )
    public function create_sales(array $params)
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
        $query = "INSERT INTO " . self::TABLE . " ({$columns}) VALUES ($values)";
        //return $query;
        # execute query
        if ($con->exec($query)) {
            $this->ID_Excel = $con->lastInsertId();
            return array("status" => true);
        } else {
            $message = "มีบางอย่างผิดพลาด , กรุณาตรวจสอบข้อมูล ";
            return array("status" => false, "message" => $message);
        }
    }

    # จัดการยอดขาย  ( เพิ่มยอดขาย excel )
    public function create_sales_at_once(array $params)
    {
        $con = Db::getInstance();
        // turn off auto commit (ปิดคำสั่งสำหรับการยืนยันการเปลี่ยนแปลงข้อมูลที่เกิดขึ้น)
        $con->beginTransaction();
        foreach ($params as $k => $v) {
            $values = "";
            $columns = "";
            foreach ($v as $prop => $val) {
                # ถ้า column แรกไม่ต้องเติมลูกน้ำ คอลัมน์อื่นเติมลูกน้ำ ..
                $columns = empty($columns) ? $columns .= $prop : $columns .= "," . $prop;
                $values .= "'$val',";
            }
            #เช็คว่ามี ID ส่งมาไหม
//            if(!isset($v['ID_Excel'])){
//                $con->rollBack();
//                $message = "มีบางอย่างผิดพลาด , ไอดียอดขายไม่สามารถเป็นค่าว่างได้ ";
//                return array("status" => false , "message" => $message);
//            }
            #ตรวจสอบรายการที่ซ้ำกัน
            /*$check_duplicate = Sales::findById($v['ID_Excel']);
            if(!empty($check_duplicate)){
                # rollback when got error (เมื่อ error ให้ยกเลิกการเปลี่ยนแปลงข้อมูลที่เกิดขึ้น)
                $con->rollBack();
                $message = "มีบางอย่างผิดพลาด , มีไอดีบริษัทลูกค้า {$v['ID_Excel']} ในระบบเเล้ว";
                return array("status" => false , "message" => $message);
            }*/
            # insert ลง db
            $values = substr($values, 0, -1);
            $query = "INSERT INTO " . self::TABLE . "({$columns}) VALUES ($values)";
            //echo $query;exit();
            # execute query
            if ($con->exec($query)) {
                # do something
            } else {
                # rollback when got error
                $con->rollBack();
                $message = "มีบางอย่างผิดพลาด , กรุณาตรวจสอบข้อมูล ";
                return array("status" => false, "message" => $message);
            }
        }
        # commit
        $con->commit();
        return array("status" => true);
    }

    public function file_log(string $file_name, int $id)
    {
        $query = "UPDATE file_log SET file_name = '{$file_name}' where id = {$id} ";
        //echo $query;exit();
        $con = Db::getInstance();
        if ($con->exec($query)) {

            return array("status" => true);
        }

    }

    # แก้ไข ยอดขาย
    public function edit_sales(array $params, string $ID_Excel)
    {
        $query = "UPDATE " . self::TABLE . " SET ";
        foreach ($params as $prop => $val) {
            if (!empty($val)) {
                $query .= " $prop='$val',";
            }
        }
        $query = substr($query, 0, -1);
        $query .= " WHERE ID_Excel = '" . $ID_Excel . "'";
        //echo $query;exit();
        $con = Db::getInstance();
        if ($con->exec($query)) {
            return array("status" => true);
        } else {

            return array("status" => false);
        }
    }

    # ลบ ยอดขาย
    public function delete_sales($ID_Excel)
    {
        $query = "DELETE FROM " . self::TABLE . " WHERE ID_Excel = '{$ID_Excel}' ";
        $con = Db::getInstance();
        if ($con->exec($query)) {
            return array("status" => true);
        } else {
            return array("status" => false);
        }
    }
}

?>

