<?php

# excel library
include Router::getSourcePath() . 'classes/Excel.class.php';


class AdminController
{

    /**
     * handleRequest จะทำการตรวจสอบ action และพารามิเตอร์ที่ส่งเข้ามาจาก Router
     * แล้วทำการเรียกใช้เมธอดที่เหมาะสมเพื่อประมวลผลแล้วส่งผลลัพธ์กลับ
     *
     * @param string $action ชื่อ action ที่ผู้ใช้ต้องการทำ
     * @param array $params พารามิเตอร์ที่ใช้เพื่อในการทำ action หนึ่งๆ
     */
    public function handleRequest(string $action = "index", array $params)
    {
        switch ($action) {
            case "index":
                $this->index();
                break;
            case "manage_user" :
                $this->$action();
                break;
            case "create_user" :
                $result = $this->$action($params["POST"]);
                echo $result;
                break;
            case "edit_user" :
                $ID_Employee = isset($params["GET"]["ID_Employee"]) ? $params["GET"]["ID_Employee"] : "";
                $result = $this->$action($params["POST"], $ID_Employee);
                echo $result;
                break;
            case "delete_user":
                $result = $this->$action($params["POST"]["ID_Employee"]);
                echo $result;
                break;
            case "import_excel":
                $FILES = isset($params["FILES"]["file"]) ? $params["FILES"]["file"] : "";
                $result = $this->$action($params["POST"], $FILES);
                echo $result;
                break;
            default:
                break;
        }

    }

    private function import_excel(array $params, array $FILES)
    {
        $excel = new Excel();
        $path = $FILES["tmp_name"];
        $object = PHPExcel_IOFactory::load($path);
        $params = array();
        foreach ($object->getWorksheetIterator() as $worksheet) {
            $highestRow = $worksheet->getHighestRow();
            $highestColumn = $worksheet->getHighestColumn();
            //  echo $highestRow;exit();
            // row = 2 คือ row แรก ไม่รวม header
            for ($row = 2; $row <= $highestRow; $row++) {
                if ($worksheet->getCellByColumnAndRow(0, $row)->getValue() != '') {
                $ID_Employee = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                $Name_Employee = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                $Surname_Employee = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                $Username_Employee = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                $Email_Employee = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                $Password_Employee = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
                $User_Status_Employee = $worksheet->getCellByColumnAndRow(6, $row)->getValue();

                $push_array = array("ID_Employee" => $ID_Employee,
                    "Name_Employee" => $Name_Employee,
                    "Surname_Employee" => $Surname_Employee,
                    "Username_Employee" => $Username_Employee,
                    "Email_Employee" => $Email_Employee,
                    "Password_Employee" => $Password_Employee,
                    "User_Status_Employee" => $User_Status_Employee
                );
                array_push($params, $push_array);
                }
            }
        }
        // # create user ใหม่
        $employee_ = new Employee();
        $result = $employee_->create_user_at_once($params);
        # update new pic
        $target_file = Router::getSourcePath() . "uploads/" . $FILES['name'];
        if (!empty($FILES) && isset($FILES['name'])) {
            if (!empty($FILES['name'])) {
                move_uploaded_file($FILES["tmp_name"], $target_file);
            }
        }
        return json_encode($result);
    }

    private function error_handle(string $message)
    {
        $this->index($message);
    }

    private function create_user($params)
    {
        # สร้างผู้ใช้
        $access_employee = new Employee();
        $employee_result = $access_employee->create_user(
            $params
        );
        return json_encode($employee_result);
    }

    private function edit_user($params, $employee_id)
    {
        # อัปเดตผู้ใช้
        $access_employee = new Employee();
        $employee_result = $access_employee->edit_user(
            $params, $employee_id
        );
        return json_encode($employee_result);
    }

    private function delete_user($ID_Employee)
    {
        # ลบผู้ใช้
        $access_employee = new Employee();
        $employee_result = $access_employee->delete_user(
            $ID_Employee
        );
        return json_encode($employee_result);
    }

    // ควรมีสำหรับ controller ทุกตัว
    private function index($message = null)
    {
        session_start();
        $employee = $_SESSION["employee"];
        include Router::getSourcePath() . "views/index_admin.inc.php";
    }

    //หน้าจัดการผู้ใช้
    private function manage_user($params = null)
    {
        session_start();
        $employee = $_SESSION["employee"];
        # retrieve data       
        $user = Employee::findAll();
        include Router::getSourcePath() . "views/admin/manage_user.inc.php";
    }

}