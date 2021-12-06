<?php

class Award_Image
{
    //------------- Properties
    private $ID_Award;
    private $Image_name;
    private const TABLE = "Award_image";



    //----------- Getters & Setters
	public function getID_Award(): int
    {
        return $this->ID_Award;
    }
    public function setID_Award(int $ID_Award)
    {
        $this->$ID_Award = $ID_Award;
    }
    public function getImage_name(): string
    {
        return $this->Image_name;
    }
    public function setImage_name(int $Image_name)
    {
        $this->$Image_name = $Image_name;
    }
   
    //----------- CRUD

    // save data to
    // insert data into server.
    public static function create_images($params)
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
        if ($con->exec($query)) {
            return array("status" => true);
        } else {
            return array("status" => false);
        }
       
    }

    public static function update_images($params)
    {

        $ID_Award = $params['ID_Award'];
        $query = "UPDATE " . self::TABLE . " SET ";
        foreach ($params as $prop => $val) {
            if($val != '') {
                $query .= " $prop='$val',";
            }
        }
        $query = substr($query, 0, -1);
        $query .= " WHERE ID_Award = '" . $ID_Award . "'";
        //print_r($query);

        $con = Db::getInstance();
        if ($con->exec($query)) {
            return array("status" => true);
        } else {

            return array("status" => false);
        }

    }
    
    public static function get_images($ID_Award): array
    {
        $con = Db::getInstance();
        $query = "SELECT * FROM " . self::TABLE." WHERE ID_Award='".$ID_Award."'";
        $stmt = $con->prepare($query);
        $stmt->setFetchMode(PDO::FETCH_CLASS, "Award_Image");
        $stmt->execute();
        $list = array();
        while ($prod = $stmt->fetch()) {
            $list[] = $prod;
        }
        return $list;

    }

    public static function delete_images($Image_name)
    {
        $con = Db::getInstance();
        $values = "";
        $columns = "";
        $query = "DELETE FROM award_image WHERE Image_name='".$Image_name."'";
        if ($con->exec($query)) {
            return array("status" => true);
        } else {
            return array("status" => false);
        }
       
    }

    public static function message_unread($ID_Employee){
        $con = Db::getInstance();
        $query = "SELECT * FROM " . self::TABLE;
        $stmt = $con->prepare($query);
        $stmt->setFetchMode(PDO::FETCH_CLASS, "Award");
        $stmt->execute();
        $msg = array();
        while ($prod = $stmt->fetch()) {
            $msg[] = $prod;
        }
        $countMsg = count($msg);

        $query = "SELECT * FROM award_status WHERE ID_Employee='".$ID_Employee."'";
        $stmt = $con->prepare($query);
        $stmt->setFetchMode(PDO::FETCH_CLASS, "Message");
        $stmt->execute();
        $read = array();
        while ($prod = $stmt->fetch()) {
            $read[] = $prod;
        }
        return $countMsg-count($read);
    }


    public static function update_message_status($ID_Employee, $ID_Award)
    {
        $con = Db::getInstance();
        $query = "SELECT * FROM award_status WHERE ID_Employee='".$ID_Employee."' AND ID_Award='".$ID_Award."'";
        $stmt = $con->prepare($query);
        $stmt->setFetchMode(PDO::FETCH_CLASS, "ID_Award");
        $stmt->execute();
        $read = array();
        while ($prod = $stmt->fetch()) {
            $read[] = $prod;
        }
        
        if(count($read)=='0'){
            $query = 'INSERT INTO award_status(ID_Employee,ID_Award,status) VALUES("'.$ID_Employee.'","'.$ID_Award.'","0")';
            $con->exec($query);
        }
       
        return array("status" => true);

    }

}

