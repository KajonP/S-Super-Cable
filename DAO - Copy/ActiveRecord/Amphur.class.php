<?php
class Amphur
{

    //------------- Properties
    private $AMPHUR_ID;
    private $AMPHUR_CODE;
    private $AMPHUR_NAME;
    private $PROVINCE_ID;
    private const TABLE = "amphur";

    //----------- Getters & Setters
    public function getAMPHUR_ID() : int
    {
        return $this->AMPHUR_ID;
    }
    public function setAMPHUR_ID(int $AMPHUR_ID)
    {
        $this->AMPHUR_ID = $AMPHUR_ID;
    }
    public function getAMPHUR_CODE() : string
    {
        return $this->AMPHUR_CODE;
    }
    public function setAMPHUR_CODE(string $AMPHUR_CODE)
    {
        $this->AMPHUR_CODE = $AMPHUR_CODE;
    }
    public function getAMPHUR_NAME() : string
    {
        return $this->AMPHUR_NAME;
    }
    public function setAMPHUR_NAME(string $AMPHUR_NAME)
    {
        $this->AMPHUR_NAME = $AMPHUR_NAME;
    }
    public function getPROVINCE_ID() : int
    {
        return $this->PROVINCE_ID;
    }
    public function setPROVINCE_ID(int $PROVINCE_ID)
    {
        $this->PROVINCE_ID = $PROVINCE_ID;
    }

    //----------- CRUD
    public static function findAll(): array
    {
        $con = Db::getInstance();
        $query = "SELECT * FROM " . self::TABLE;
        $stmt = $con->prepare($query);
        $stmt->setFetchMode(PDO::FETCH_CLASS, "Amphur");
        $stmt->execute();
        $amphurList = array();
        while ($prod = $stmt->fetch()) {
            $amphurList[$prod->getAMPHUR_ID()] = $prod;
        }
        return $amphurList;
    }
    public static function findById(int $AMPHUR_ID): ?Amphur
    {
        $con = Db::getInstance();
        $query = "SELECT * FROM " . self::TABLE . " WHERE AMPHUR_ID = '$AMPHUR_ID'";
        $stmt = $con->prepare($query);
        $stmt->setFetchMode(PDO::FETCH_CLASS, "Amphur");
        $stmt->execute();
        if ($prod = $stmt->fetch()) {
            return $prod;
        }
        return null;
    }

}
