<?php

class EmployeeController {

    /**
     * handleRequest จะทำการตรวจสอบ action และพารามิเตอร์ที่ส่งเข้ามาจาก Router
     * แล้วทำการเรียกใช้เมธอดที่เหมาะสมเพื่อประมวลผลแล้วส่งผลลัพธ์กลับ
     *
     * @param string $action ชื่อ action ที่ผู้ใช้ต้องการทำ
     * @param array $params พารามิเตอร์ที่ใช้เพื่อในการทำ action หนึ่งๆ
     */
    public function handleRequest(string $action="index", array $params) {
        switch ($action) {
            case "login":
                $Username_Employee = $params["POST"]["Username_Employee"]??"";
                $Password_Employee	 = $params["POST"]["Password_Employee"]??"";
                $RememberMe = $params["POST"]["RememberMe"]??"";
                if ($Username_Employee !== "" && $Password_Employee	 !== "") {
                    $this->$action($Username_Employee, $Password_Employee , $RememberMe);
                } 
                else{
                    # error handle : if empty username or password
                    $message = json_encode("Username หรือ Password ไม่สามารถว่างได้ , โปรดลองอีกครั้ง ");
                    header("Location: " .Router::getSourcePath()."index.php?controller=ErrorHandle&action=error_handle&message={$message}");
                }
                break;
            case "logout" :
                session_start();
                # ลบตัวแปร session ทั้งหมด
                session_destroy();
                # redirect ไปหน้า login 
                // header("Location: " . Router::getSourcePath() . "index.php");
                # status ที่จะ return กลับไปเป็น json
                echo json_encode(array("status" => true));
                break;
            case "index":
                $this->index();
                break;
            case "edit_profile":
                    $FILES = isset($params["FILES"]["profile"]) ? $params["FILES"]["profile"] : "";
                    $result = $this->$action($params["POST"] , $FILES );
                    echo $result;
                break;
            case "findbyID":
                $ID_Employee = isset($params["POST"]["ID_Employee"]) ? $params["POST"]["ID_Employee"] : "";
                
                if(!empty($ID_Employee)){
                    $result = $this->$action($ID_Employee);
                    echo $result;
                }
                break;
            default:
                break;
        }
    }

    private function findbyID(string $ID_Employee){
           $employee =  Employee::findById($ID_Employee);//echo json_encode($employee);
           
           $data_sendback = array(
                "ID_Employee" => $employee->getID_Employee(),
                "Name_Employee" => $employee->getName_Employee(),
                "Surname_Employee" => $employee->getSurname_Employee(),
                "Username_Employee" => $employee->getUsername_Employee(),
                "User_Status_Employee" => $employee->getUser_Status_Employee(),
                "Email_Employee" => $employee->getEmail_Employee()
           );
           echo json_encode(array("data" => $data_sendback));

    }
    private function edit_profile(array $Params , array $FILES ) {
            session_start();
            $employee = $_SESSION["employee"];
            # update profile
            $access_employee = new Employee();
       
            if(isset($Params["Password_Employee_Profile"])){
                $Params["Password_Employee"] = $Params["Password_Employee_Profile"];
                unset($Params["Password_Employee_Profile"]);
                unset($Params["Password_Employee_Profile_Confirm"]);
            }
         

            $employee_update_result = $access_employee->updateProfile(
                $Params
              , $FILES 
              , $employee->getID_Employee() );
            if($employee_update_result == true){
                $_POST['Username_Employee'] = $Params['Username_Employee'];
                $_POST['Password_Employee'] = $Params['Password_Employee'];
            }
            return json_encode($employee_update_result);
    }
    private function login(string $Username_Employee, string $Password_Employee , string $RememberMe) {
        $employee = Employee::findByAccount($Username_Employee,$Password_Employee) ;
        if ($employee !== null){
            session_start();
            $_SESSION['employee'] = $employee;
            #  using cookie that store value on the client-side 
            if($RememberMe != ""){
                # clear old cookie before add new one
                if(isset($_COOKIE["remember_me_username_employee"]) || isset($_COOKIE["remember_me_password_employee"])){
                    unset($_COOKIE['remember_me_username_employee']); 
                    setcookie('remember_me_username_employee', null, -1, '/');
                    unset($_COOKIE['remember_me_password_employee']); 
                    setcookie('remember_me_password_employee', null, -1, '/');
                   
                }
                $cookie_value = array(
                    'Username_Employee'=>base64_encode(base64_encode($Username_Employee)),
                    'Password_Employee'=>base64_encode(base64_encode($Password_Employee))
                );
                setcookie("remember_me_username_employee"
                , $cookie_value['Username_Employee']
                , time() + (86400 * 30) // 86400 = 1 day
                , "/");
                setcookie("remember_me_password_employee"
                , $cookie_value['Password_Employee']
                , time() + (86400 * 30)
                , "/");
            }
          // print_r($employee -> getUser_Status_Employee());
            if ($employee -> getUser_Status_Employee() == "Admin" ) {
                include Router::getSourcePath() . "views/index_admin.inc.php";
            }
            else if ($employee -> getUser_Status_Employee() == "Sales" ) {
                include Router::getSourcePath()."views/index_sale.inc.php";
            }
            else if ($employee -> getUser_Status_Employee()== "User"){
                include Router::getSourcePath()."views/index_user.inc.php";
            }
        }else{
           
            # error handle : if username or password incorrect
            $message = json_encode("Username or Password incorrect ");
            header("Location: " .Router::getSourcePath()."index.php?controller=ErrorHandle&action=error_handle&message={$message}");
        }
       
    }

    // ควรมีสำหรับ controller ทุกตัว
    private function index() {
        include Router::getSourcePath()."views/login.inc.php";
    }

}