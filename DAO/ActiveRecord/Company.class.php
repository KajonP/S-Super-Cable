<?php

class Company
{
    //------------- Properties
    private $ID_Company;
    private $Name_Company;
    private $Address_Company;
    private $Tel_Company;
    private $Email_Company;
    private $Tax_Number_Company;
    private $Credit_Limit_Company;
    private $Credit_Term_Company;
    private $Cluster_Shop;
    private $Contact_Name_Company;
    private $IS_Blacklist;
    private $Cause_Blacklist;
    private $AMPHUR_ID;
    private $AMPHUR_CODE;
    private $AMPHUR_NAME;
    private $PROVINCE_ID;
    
    private const TABLE = "company";

    //----------- Getters & Setters
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
        $this->Name_Company = $Name_Company;
    }

    public function getAddress_Company(): string
    {
        return $this->Address_Company;
    }

    public function setAddress_Company(string $Address_Company)
    {
        $this->Address_Company = $Address_Company;
    }

    public function getTel_Company(): string
    {
        return $this->Tel_Company;
    }

    public function setTel_Company(string $Tel_Company)
    {
        $this->Tel_Company = $Tel_Company;
    }

    public function getEmail_Company(): string
    {
        return $this->Email_Company;
    }

    public function setEmail_Company(string $Email_Company)
    {
        $this->Email_Company = $Email_Company;
    }

    public function getTax_Number_Company(): string
    {
        return $this->Tax_Number_Company;
    }

    public function setTax_Number_Company(string $Tax_Number_Company)
    {
        $this->Tax_Number_Company = $Tax_Number_Company;
    }

    public function getCredit_Limit_Company(): int
    {
        return $this->Credit_Limit_Company;
    }

    public function setCredit_Limit_Company(int $Credit_Limit_Company)
    {
        $this->Credit_Limit_Company = $Credit_Limit_Company;
    }

    public function getCredit_Term_Company(): string
    {
        return $this->Credit_Term_Company;
    }

    public function setCredit_Term_Company(string $Credit_Term_Company)
    {
        $this->Credit_Term_Company = $Credit_Term_Company;
    }

    public function getCluster_Shop(): string
    {
        return $this->Cluster_Shop;
    }

    public function setCluster_Shop(string $Cluster_Shop)
    {
        $this->Cluster_Shop = $Cluster_Shop;
    }

    public function getContact_Name_Company(): string
    {
        if ($this->Contact_Name_Company == null)
            return "-";
        else
            return $this->Contact_Name_Company;

    }

    public function setContact_Name_Company(string $Contact_Name_Company)
    {
        $this->Contact_Name_Company = $Contact_Name_Company;
    }

    public function getIS_Blacklist(): string
    {
        return $this->IS_Blacklist;
    }

    public function setIS_Blacklist(string $IS_Blacklist)
    {
        $this->IS_Blacklist = $IS_Blacklist;
    }

    public function getCause_Blacklist(): string
    {
        if ($this->Cause_Blacklist == null)
            return "-";
        else
            return $this->Cause_Blacklist;
    }

    public function setCause_Blacklist(string $Cause_Blacklist)
    {
        $this->Cause_Blacklist = $Cause_Blacklist;
    }

    public function getAMPHUR_ID(): string
    {
        if ($this->AMPHUR_ID == null)
            return "-";
        else
            return $this->AMPHUR_ID;
    }

    public function setAMPHUR_ID(string $AMPHUR_ID)
    {
        $this->AMPHUR_ID = $AMPHUR_ID;
    }
    public function getAMPHUR_CODE(): string
    {
        if ($this->AMPHUR_CODE == null)
            return "-";
        else
            return $this->AMPHUR_CODE;
    }

    public function setAMPHUR_CODE(string $AMPHUR_CODE)
    {
        $this->AMPHUR_CODE = $AMPHUR_CODE;
    }

    public function getAMPHUR_NAME(): string
    {
        if ($this->AMPHUR_NAME == null)
            return "-";
        else
            return $this->AMPHUR_NAME;
    }

    public function setAMPHUR_NAME(string $AMPHUR_NAME)
    {
        $this->AMPHUR_NAME = $AMPHUR_NAME;
    }

    public function getPROVINCE_ID(): string
    {
        if ($this->PROVINCE_ID == null)
            return "-";
        else
            return $this->PROVINCE_ID;
    }

    public function setPROVINCE_ID(string $PROVINCE_ID)
    {
        $this->PROVINCE_ID = $PROVINCE_ID;
    }

    


    //----------- CRUD
    public static function findAll(): array
    {
        $con = Db::getInstance();
        $query = "SELECT * FROM " . self::TABLE;
        $stmt = $con->prepare($query);
        $stmt->setFetchMode(PDO::FETCH_CLASS, "Company");
        $stmt->execute();
        $companyList = array();
        while ($prod = $stmt->fetch()) {
            $companyList[$prod->getID_Company()] = $prod;
        }
        return $companyList;
    }

    public static function findById(int $ID_Company): ?Company
    {
        $con = Db::getInstance();
        $query = "SELECT * FROM " . self::TABLE . " WHERE ID_Company = '$ID_Company'";
       
        $stmt = $con->prepare($query);
        $stmt->setFetchMode(PDO::FETCH_CLASS, "Company");
        $stmt->execute();
        if ($prod = $stmt->fetch()) {
        
            return $prod;
        }
        return null;
    }

    # จัดการบริษัทลูกค้า  ( เพิ่มบริษัทลูกค้า )
    public function create_company(array $params)
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

    # จัดกาบริษัทลูกค้า  ( เพิ่มบริษัทลูกค้า excel )
    public function create_company_at_once(array $params)
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
            if (!isset($v['ID_Company'])) {
                $con->rollBack();
                $message = "มีบางอย่างผิดพลาด , ไอดีบริษัทลูกค้าไม่สามารถเป็นค่าว่างได้ ";
                return array("status" => false, "message" => $message);
            }
            #ตรวจสอบรายการที่ซ้ำกัน
            $check_duplicate = Company::findById($v['ID_Company']);
            if (!empty($check_duplicate)) {
                # rollback when got error (เมื่อ error ให้ยกเลิกการเปลี่ยนแปลงข้อมูลที่เกิดขึ้น)
                $con->rollBack();
                $message = "มีบางอย่างผิดพลาด , มีไอดีบริษัทลูกค้า {$v['ID_Company']} ในระบบเเล้ว";
                return array("status" => false, "message" => $message);
            }
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

    # แก้ไข company
    public function edit_company(array $params, string $ID_Company)
    {
        $query = "UPDATE " . self::TABLE . " SET ";
        foreach ($params as $prop => $val) {
            $query .= " $prop='$val',";
        }
        $query = substr($query, 0, -1);
        $query .= " WHERE ID_Company = '" . $ID_Company . "'";
        //echo $query;exit();
        $con = Db::getInstance();
        if ($con->exec($query)) {
            return array("status" => true);
        } else {

            return array("status" => false);
        }
    }

    # ลบ company
    public function delete_company($ID_Company)
    {
        $query = "DELETE FROM " . self::TABLE . " WHERE ID_Company = '{$ID_Company}' ";
        $con = Db::getInstance();
        if ($con->exec($query)) {
            return array("status" => true);
        } else {
            return array("status" => false);
        }
    }

    public function export_excel(string $page)
    {

    }


    public function getAmphur(int $PROVINCE_ID){
        $con = Db::getInstance();
        $query = "SELECT * FROM amphur WHERE PROVINCE_ID = '$PROVINCE_ID'";
        //echo $query;exit();
        $stmt = $con->prepare($query);
        $stmt->setFetchMode(PDO::FETCH_CLASS, "amphur");
        $stmt->execute();
        $returndata = array();
       
        if ($prod = $stmt->fetch()) {
            
            while ($prod = $stmt->fetch()) {
                $array_pushs = array("AMPHUR_ID" => $prod->getAMPHUR_ID()
                , "AMPHUR_CODE" => $prod->getAMPHUR_CODE()
                , "AMPHUR_NAME" => $prod->getAMPHUR_NAME()
                , "PROVINCE_ID" => $prod->getPROVINCE_ID());
                
                array_push($returndata , $array_pushs);
            }
        }
        if(!empty($returndata)){
            return $returndata;
        }else{
            return null;
        }
    }
}

?>