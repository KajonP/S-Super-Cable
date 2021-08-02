<?php

class Cluster_Shop
{
    //------------- Properties
    private $Cluster_Shop_ID;
    private $Cluster_Shop_Name;
    private const TABLE = "cluster_shop";


    //----------- Getters & Setters
    public function getCluster_Shop_ID(): int
    {
        return $this->Cluster_Shop_ID;
    }
    public function setCluster_Shop_ID(int $Cluster_Shop_ID)
    {
        $this->$Cluster_Shop_ID = $Cluster_Shop_ID;
    }
    public function getCluster_Shop_Name(): string
    {
        return $this->Cluster_Shop_Name;
    }
    public function setCluster_Shop_Name(string $Cluster_Shop_Name)
    {
        $this->$Cluster_Shop_Name = $Cluster_Shop_Name;
    }


    //----------- CRUD
    public static function findAll(): array
    {
        $con = Db::getInstance();
        $query = "SELECT * FROM " . self::TABLE;
        $stmt = $con->prepare($query);
        $stmt->setFetchMode(PDO::FETCH_CLASS, "cluster_shop");
        $stmt->execute();
        $cluster_shopList = array();
        while ($prod = $stmt->fetch()) {
            $cluster_shopList[$prod->getCluster_Shop_ID()] = $prod;
        }
        return $cluster_shopList;
    }
    public static function findById(string $Cluster_Shop_ID): ?Cluster_Shop
    {
        $con = Db::getInstance();
        $query = "SELECT * FROM " . self::TABLE . " WHERE Cluster_Shop_ID = '$Cluster_Shop_ID'";
        $stmt = $con->prepare($query);
        $stmt->setFetchMode(PDO::FETCH_CLASS, "cluster_shop");
        $stmt->execute();
        if ($prod = $stmt->fetch()) {
            return $prod;
        }
        return null;
    }
    # จัดการกลุ่มลูกค้า  ( เพิ่มกลุ่มลูกค้า )
    public function create_cluster_shop(array $params)
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
    # แก้ไขกลุ่มลูกค้า
    public function edit_cluster_shop(array $params, string $Cluster_Shop_ID)
    {
        $query = "UPDATE " . self::TABLE . " SET ";
        foreach ($params as $prop => $val) {
            if (!empty($val)) {
                $query .= " $prop='$val',";
            }
        }
        $query = substr($query, 0, -1);
        $query .= " WHERE Cluster_Shop_ID = '" . $Cluster_Shop_ID . "'";
        //echo $query;exit();
        $con = Db::getInstance();
        if ($con->exec($query)) {
            return array("status" => true);
        } else {

            return array("status" => false);
        }
    }

    # ลบกลุ่มลูกค้า
    public function delete_cluster_shop($Cluster_Shop_ID)
    {
        $query = "DELETE FROM " . self::TABLE . " WHERE Cluster_Shop_ID = '{$Cluster_Shop_ID}' ";
        $con = Db::getInstance();
        if ($con->exec($query)) {
            return array("status" => true);
        } else {
            return array("status" => false);
        }
    }

}