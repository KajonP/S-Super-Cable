<?php

class File
{
    //------------- Properties
    private $ID_File;
    private $Name_File;
    private $Path_File;
    private const TABLE = "file";

    //----------- Getters & Setters
    public function getID_File(): int
    {
        return $this->ID_File;
    }
    public function setID_File(int $ID_File)
    {
        $this->ID_File = $ID_File;
    }
    public function getName_File(): string
    {
        return $this->Name_File;
    }
    public function setName_File(int $Name_File)
    {
        $this->Name_File = $Name_File;
    }
    public function getPath_File(): string
    {
        return $this->Path_File;
    }
    public function setPath_File(int $Path_File)
    {
        $this->Path_File = $Path_File;
    }
    public function getSize_File(): int
    {
        return $this->Size_File;
    }
    public function setSize_File(int $Size_File)
    {
        $this->Size_File = $Size_File;
    }
    //----------- CRUD
    public static function findAll(): array
    {
        $con = Db::getInstance();
        $query = "SELECT * FROM " . self::TABLE;
        $stmt = $con->prepare($query);
        $stmt->setFetchMode(PDO::FETCH_CLASS, "File");
        $stmt->execute();
        $fileList = array();
        while ($prod = $stmt->fetch()) {
            $fileList[$prod->getID_File()] = $prod;
        }
        return $fileList;
    }
    public static function findById(string $ID_File): ?File
    {
        $con = Db::getInstance();
        $query = "SELECT * FROM " . self::TABLE . " WHERE ID_File = '$ID_File'";
        $stmt = $con->prepare($query);
        $stmt->setFetchMode(PDO::FETCH_CLASS, "File");
        $stmt->execute();
        if ($prod = $stmt->fetch()) {
            return $prod;
        }
        return null;
    }
    # จัดการไฟล์  ( เพิ่มไฟล์ )
    public function create_file(array $params)
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
    # แก้ไขไฟล์
    public function edit_file(array $params, string $ID_File)
    {
        $query = "UPDATE " . self::TABLE . " SET ";
        foreach ($params as $prop => $val) {
            if (!empty($val)) {
                $query .= " $prop='$val',";
            }
        }
        $query = substr($query, 0, -1);
        $query .= " WHERE ID_File = '" . $ID_File . "'";
        //echo $query;exit();
        $con = Db::getInstance();
        if ($con->exec($query)) {
            return array("status" => true);
        } else {

            return array("status" => false);
        }
    }
    # ลบไฟล์
    public function delete_file($ID_File)
    {
        $query = "DELETE FROM " . self::TABLE . " WHERE ID_File = '{$ID_File}' ";
        $con = Db::getInstance();
        if ($con->exec($query)) {
            return array("status" => true);
        } else {
            return array("status" => false);
        }
    }
}
?>