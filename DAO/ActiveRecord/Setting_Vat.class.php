<?php

class Setting_Vat
{
    //------------- Properties
    private $ID_Setting_Vat;
    private $Percent_Vat;
    private $Date_Setting;
    private const TABLE = "setting_vat";

    //----------- Getters & Setters
    public function getID_Setting_Vat(): int
    {
        return $this->ID_Setting_Vat;
    }
    public function setID_Setting_Vat(int $ID_Setting_Vat)
    {
        $this->$ID_Setting_Vat = $ID_Setting_Vat;
    }
    public function getPercent_Vat(): int
    {
        return $this->Percent_Vat;
    }
    public function setPercent_Vat(int $Percent_Vat)
    {
        $this->$Percent_Vat = $Percent_Vat;
    }
    public function getDate_Setting(): string
    {
        return $this->Date_Setting;
    }
    public function setDate_Setting(string $Date_Setting)
    {
        $this->$Date_Setting = $Date_Setting;
    }

    //----------- CRUD
    public static function findAll(): array
    {
        $con = Db::getInstance();
        $query = "SELECT * FROM " . self::TABLE;
        $stmt = $con->prepare($query);
        $stmt->setFetchMode(PDO::FETCH_CLASS, "Setting_Vat");
        $stmt->execute();
        $setting_vatList = array();
        while ($prod = $stmt->fetch()) {
            $setting_vatList[$prod->getID_Setting_Vat()] = $prod;
        }
        return $setting_vatList;
    }
    public static function findById(string $ID_Setting_Vat): ?Setting_Vat
    {
        $con = Db::getInstance();
        $query = "SELECT * FROM " . self::TABLE . " WHERE ID_Setting_Vat = '$ID_Setting_Vat'";
       // print_r($query);
        $stmt = $con->prepare($query);
        $stmt->setFetchMode(PDO::FETCH_CLASS, "Setting_Vat");
        $stmt->execute();
        if ($prod = $stmt->fetch()) {
            return $prod;
        }
        return null;
    }
    # แก้ไข vat
    public function edit_setting_vat(array $params, string $ID_Setting_Vat)
    {
        $query = "UPDATE " . self::TABLE . " SET " ;
        foreach ($params as $prop => $val) {
            if (!empty($val)) {
                $query .= " $prop='$val',";
            }
        }
        $query = substr($query, 0, -1);
        $query .= " WHERE ID_Setting_Vat = '" . $ID_Setting_Vat . "'";

        //echo $query;exit();
        $con = Db::getInstance();
        if ($con->exec($query)) {
            return array("status" => true);
        } else {

            return array("status" => false);
        }
    }

}