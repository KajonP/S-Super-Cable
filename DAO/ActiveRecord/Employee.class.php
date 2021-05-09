<?php

class Employee
{
    //------------- Properties
    private $ID_Employee;
    private $Name_Employee;
    private $Surname_Employee;
    private $Username_Employee;
    private $Password_Employee;
    private $Email_Employee;
    private $Picture_Employee;
    private $User_Status_Employee;
    public  $current_password;
    private const TABLE = "employee";

    //----------- Getters & Setters
    public function getID_Employee():string
    {
        return $this->ID_Employee;
    }
    public function setID_Employee(string $ID_Employee)
    {
        $this->ID_Employee = $ID_Employee;
    }
    public function getName_Employee():string
    {
        return $this->Name_Employee;
    }
    public function setName_Employee(string $Name_Employee)
    {
        $this->Name_Employee = $Name_Employee;
    }
    public function getSurname_Employee():string
    {
        return $this->Surname_Employee;
    }
    public function setSurname_Employee(string $Surname_Employee)
    {
        $this->Surname_Employee = $Surname_Employee;
    }
    public function getUsername_Employee():string
    {
        return $this->Username_Employee;
    }

    public function setUsername_Employee(string $Username_Employee)
    {
        $this-> Username_Employee = $Username_Employee;
    }
    public function getPassword_Employee(): string
    {
        return $this->Password_Employee;
    }
    public function setPassword_Employee(string $Password_Employee)
    {
        $this->Password_Employee = $Password_Employee;
    }
    public function getEmail_Employee(): string
    {
        return $this->Email_Employee;
    }
    public function setEmail_Employee(string $Email_Employee)
    {
        $this->Email_Employee = $Email_Employee;
    }
    public function getPicture_Employee(): string
    {
        return $this->Picture_Employee;
    }
    public function setPicture_Employee(string $Picture_Employee)
    {
        $this->Picture_Employee = $Picture_Employee;
    }
    public function getUser_Status_Employee(): string
    {
        return $this->User_Status_Employee;
    }
    public function setUser_Status_Employee(string $User_Status_Employee)
    {
        $this->User_Status_Employee = $User_Status_Employee;
    }
    public function getCurrent_Password_Employee(): string
    {
        return $this->current_password;
    }
    public function setCurrent_Password_Employee(string $current_password)
    {
        $this->current_password = $current_password;
    }
    
    //----------- CRUD
    public static function findAll(): array {
        $con = Db::getInstance();
        $query = "SELECT * FROM ".self::TABLE;
        $stmt = $con->prepare($query);
        $stmt->setFetchMode(PDO::FETCH_CLASS, "Employee");
        $stmt->execute();
        $employeeList  = array();
        while ($prod = $stmt->fetch())
        {
            $employeeList[$prod->getID_Employee()] = $prod;
        }
        return $employeeList;
    }

    public static function findById(string $ID_Employee): ?Employee {
        $con = Db::getInstance();
        $query = "SELECT * FROM ".self::TABLE." WHERE ID_Employee = '$ID_Employee'";
        $stmt = $con->prepare($query);
        $stmt->setFetchMode(PDO::FETCH_CLASS, "Employee");
        $stmt->execute();
        if ($prod = $stmt->fetch())
        {
            return $prod;
        }
        return null;
    }
    public static function findByAccount(String $Username_Employee,String $Password_Employee): ?Employee {
        $con = Db::getInstance();
        $query = "SELECT * , '". $Password_Employee . "' as current_password FROM ".self::TABLE." WHERE Username_Employee = '$Username_Employee' AND Password_Employee = sha1('$Password_Employee')";
        //echo $query;exit();
        $stmt = $con->prepare($query);
        $stmt->setFetchMode(PDO::FETCH_CLASS, "Employee");
        $stmt->execute();
        
        if ($prod = $stmt->fetch())
        {
            return $prod;
        }
        return null;
    }
    public  function findLastestIDByRole(String $User_Status_Employee) {
        $con = Db::getInstance();
        $query = "SELECT MAX(CAST(SUBSTRING(ID_Employee, 2, 4) AS SIGNED)) as last_id  FROM ".self::TABLE." WHERE User_Status_Employee = '$User_Status_Employee' ";
        //echo $query;exit();
        $stmt = $con->prepare($query);
        $stmt->setFetchMode(PDO::FETCH_CLASS, "Employee");
        $stmt->execute();
        if ($prod = $stmt->fetch())
        {
            $prefix = "";
            # set prefix
            if($User_Status_Employee == "Admin"){
                $prefix ="a";
            }else if($User_Status_Employee == "Sales"){
                $prefix ="s";
            }else {
                $prefix ="u";
            }
            # ex. 0001
            $strings = "";
            # hardcode เช็คว่า max id หลักไร
            $autoincre = intval($prod->last_id) + 1;
            # set digit
            $string_length = strlen($autoincre);
            for($i = 4; $i > $string_length; $i --){
                $strings .= "0";
            }
            $strings = $strings . $autoincre;
            return $prefix . $strings;
        }
        return null;
    }
    # จัดการผู้ใช้  ( เพิ่มผู้ใช้ )
    public function create_user(Array $params) {
        $con = Db::getInstance();
        $values = "";
        $columns = "";
        foreach ($params as $prop => $val) {
            # case : update password
            if($prop == "Password_Employee"){
                $new_password = $val;
                $val = sha1($val);
            }
            # ถ้า column แรกไม่ต้องเติมลูกน้ำ คอลัมน์อื่นเติมลูกน้ำ ..
            $columns =  empty($columns) ? $columns .= $prop :  $columns .= "," .$prop;
            $values .= "'$val',";
        }
        # autoincrement id employee
        // $ID_Employee = $this->findLastestIDByRole($params["User_Status_Employee"]);
        // $columns .= " ,ID_Employee ";
        // $values .= "'$ID_Employee',";
        $values = substr($values,0,-1);
        $query = "INSERT INTO ".self::TABLE."({$columns}) VALUES ($values)";
        # execute query
        if($con->exec($query)){
            return array("status" => true  );
        }else{
            $message = "มีบางอย่างผิดพลาด , กรุณาตรวจสอบข้อมูล ";
            return array("status" => false , "message" => $message);
        }
    }
     # จัดการผู้ใช้  ( เพิ่มผู้ใช้ )
     public function create_user_at_once(Array $params) {
        $con = Db::getInstance();
        // turn of auto commit
        $con->beginTransaction();
        foreach ($params as $k => $v) {
            $values = "";
            $columns = "";
            foreach($v as $prop => $val){
                if($prop == "Password_Employee"){
                    $new_password = $val;
                    $val = sha1($val);
                }
                    # ถ้า column แรกไม่ต้องเติมลูกน้ำ คอลัมน์อื่นเติมลูกน้ำ ..
                    $columns =  empty($columns) ? $columns .= $prop :  $columns .= "," .$prop;
                    $values .= "'$val',";
            }
            #เช็คว่ามี ID ส่งมาไหม
            if(!isset($v['ID_Employee'])){
                $con->rollBack();
                $message = "มีบางอย่างผิดพลาด , ไอดีพนักงานไม่สามารถเป็นค่าว่างได้ ";
                return array("status" => false , "message" => $message); 
            }
            #check duplicate
            $check_duplicate = Employee::findById($v['ID_Employee']);
            if(!empty($check_duplicate)){
                # rollback when got error 
                $con->rollBack();
                $message = "มีบางอย่างผิดพลาด , มีไอดีพนักงาน {$v['ID_Employee']} ในระบบเเล้ว";
                return array("status" => false , "message" => $message); 
            }
            #eof check duplicate
            #check first char contains only letters
            //เช็คถ้าตัวอักษรตัวแรกไม่ใช่ภาษาอังกฤษ return error กลับไปครับ
            $first_char = substr($v['ID_Employee'], 0, 1);
            if(!ctype_alpha($first_char)){
                 # rollback when got error 
                 $con->rollBack();
                 $message = "มีบางอย่างผิดพลาด , ตัวอักษรเเรกของไอดีพนักงาน(you value is {$first_char}) ต้องเป็นตัวอักษร";
                 return array("status" => false , "message" => $message); 
            }
            # insert ลง db
            $values = substr($values,0,-1);
            $query = "INSERT INTO ".self::TABLE."({$columns}) VALUES ($values)";
            //echo $query;exit();
              # execute query
            if($con->exec($query)){
               # do something
            }else{
                # rollback when got error 
                $con->rollBack();
                $message = "มีบางอย่างผิดพลาด , กรุณาตรวจสอบข้อมูล ";
                return array("status" => false , "message" => $message);
            }
        }
        # commit
        $con->commit();
        return array("status" => true  );
    }
    # แก้ไข user
    public function edit_user(array $params ,string $employee_id){
        $query = "UPDATE ".self::TABLE." SET ";
        foreach ($params as $prop => $val) {
            # case : update password
            if(!empty($val)){
                if($prop == "Password_Employee"){
                    $new_password = $val;
                    $val = sha1($val);
                }
                $query .= " $prop='$val',";
            }
        }
        $query = substr($query, 0, -1);
        $query .= " WHERE ID_Employee = '".$employee_id. "'";
        //echo $query;exit();
        $con = Db::getInstance();
        if($con->exec($query)){
            return array("status" => true );
        }else{
            
            return array("status" => false );
        }
    }
    # ลบ user
    public function delete_user($ID_Employee) {
        $query = "DELETE FROM ".self::TABLE." WHERE ID_Employee = '{$ID_Employee}' ";
        
        $con = Db::getInstance();
        if($con->exec($query)){
            return array("status" => true  );
        }else{
            return array("status" => false  );
        }
    }
    # แก้ไข profile
    public function updateProfile(
     Array $params
    ,Array $FILES
    ,string $employee_id
    ) {
        $newfilename = "";
        $query = "UPDATE ".self::TABLE." SET ";
        foreach ($params as $prop => $val) {
            # case : update password
            if($prop == "Password_Employee"){
                $new_password = $val;
                $val = sha1($val);
            }
            $query .= " $prop='$val',";
        }
         # case : update picture employee
        if(!empty($FILES) && isset($FILES['name'])){
            if(!empty($FILES['name'])){
                $temp = explode(".", $FILES["name"]);
                $newfilename = sha1(round(microtime(true))) . '.' . end($temp);

                $query .= " Picuture_Employee= '{$newfilename}''";
            }
        }
        $query = substr($query, 0, -1);
        $query .= " WHERE ID_Employee = '".$employee_id. "'";
        $con = Db::getInstance();
        if($con->exec($query)){
            # update new pic
            $target_file = Router::getSourcePath(). "images/" . $newfilename;
            if(!empty($FILES) && isset($FILES['name'])){
                if(!empty($FILES['name'])){
                    move_uploaded_file($FILES["tmp_name"], $target_file);
                }
            }
            # set new session
            $employee = $this->findByAccount($params['Username_Employee'],$new_password);
            $_SESSION['employee'] = $employee;
            $this->setCurrent_Password_Employee($new_password);
            return array("status" => true , "role" => $employee->getUser_Status_Employee() );
        }else{
            $employee = $this->findById($employee_id);
            $message = "มีบางอย่างผิดพลาด , กรุณาตรวจสอบข้อมูล ";
            return array("status" => false , "role" => $employee->getUser_Status_Employee(), "message" => $message);
        }
       
        
    }

}
