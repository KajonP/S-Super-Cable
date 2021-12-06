<?php
class Province
{
    //------------- Properties
    private $PROVINCE_ID;
    private $PROVINCE_CODE;
    private $PROVINCE_NAME;
    private const TABLE = "province";

    //----------- Getters & Setters

    public function getPROVINCE_ID() : int
    {
        return $this->PROVINCE_ID;
    }
    public function setPROVINCE_ID(int $PROVINCE_ID)
    {
        $this->PROVINCE_ID = $PROVINCE_ID;
    }
    public function getPROVINCE_CODE() : string
    {
        return $this->PROVINCE_CODE;
    }
    public function setPROVINCE_CODE(string $PROVINCE_CODE)
    {
        $this->PROVINCE_CODE = $PROVINCE_CODE;
    }
    public function getPROVINCE_NAME() : string
    {
        return $this->PROVINCE_NAME;
    }
    public function setPROVINCE_NAME(string $PROVINCE_NAME)
    {
        $this->PROVINCE_NAME = $PROVINCE_NAME;
    }

    //----------- CRUD
    public static function findAll(): array
    {
        $con = Db::getInstance();
        $query = "SELECT * FROM " . self::TABLE;
        $stmt = $con->prepare($query);
        $stmt->setFetchMode(PDO::FETCH_CLASS, "Province");
        $stmt->execute();
        $provinceList = array();
        while ($prod = $stmt->fetch()) {
            $provinceList[$prod->getPROVINCE_ID()] = $prod;
        }
        return $provinceList;
    }
    public static function findById(int $PROVINCE_ID): ?Province
    {
        $con = Db::getInstance();
        $query = "SELECT * FROM " . self::TABLE . " WHERE PROVINCE_ID = '$PROVINCE_ID'";
        $stmt = $con->prepare($query);
        $stmt->setFetchMode(PDO::FETCH_CLASS, "Province");
        $stmt->execute();
        if ($prod = $stmt->fetch()) {
            return $prod;
        }
        return null;
    }

}
