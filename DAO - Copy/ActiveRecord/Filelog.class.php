<?php

class Filelog
{
    //------------- Properties
    private $ID;
    private $page;
    private const TABLE = "file_log";

    //----------- Getters & Setters
    public function getID(): string
    {
        return $this->ID;
    }

    public function getPage(): string
    {
        return $this->page;
    }

    public function setID(string $ID)
    {
        $this->ID = $ID;
    }

    public function setPage(string $page)
    {
        $this->page = $page;
    }


    //----------- CRUD
    public static function findAll(): array
    {
        $con = Db::getInstance();
        $query = "SELECT * FROM " . self::TABLE;
        $stmt = $con->prepare($query);
        $stmt->setFetchMode(PDO::FETCH_CLASS, "file_log");
        $stmt->execute();
        $filelogList = array();
        while ($prod = $stmt->fetch()) {
            $filelogList[$prod->getID()] = $prod;
        }
        return $filelogList;
    }

    public static function findByPage(string $page)
    {
        $con = Db::getInstance();
        $query = "SELECT * FROM " . self::TABLE . " WHERE page = '$page'";

        $stmt = $con->prepare($query);
        $stmt->setFetchMode(PDO::FETCH_CLASS, "file_log");
        $stmt->execute();
        if ($prod = $stmt->fetch()) {
            return $prod;
        }
        return null;
    }


}
