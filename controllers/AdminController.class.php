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
                $FILE_IMG = isset($params["FILES"]["examfile"]) ? $params["FILES"]["examfile"] : "";
                $result = $this->$action($params["POST"], $FILES , $FILE_IMG);
                echo $result;
                break;
            default:
                break;
        }

    }

    private function import_excel(array $params, array $FILES , array $FILE_IMG)
    {
        $excel = new Excel();
        #UPLOAD IMAGE
        if(!empty($FILE_IMG) && !empty($FILE_IMG['name'])){
             # update new pic
             $target_file_img = Router::getSourcePath() . "images/" . $FILE_IMG['name'];
            
             if (!empty($FILE_IMG) && isset($FILE_IMG['name'])) {
                 if (!empty($FILE_IMG['name'])) {
                     move_uploaded_file($FILE_IMG["tmp_name"], $target_file_img);
                    
                     $employee_ = new Employee();
                     $employee_->file_log($FILE_IMG['name']  , 1);
                 }
             }
            
        }
        
        #UPLOAD EXCEL
       
        if(!empty($FILES) && !empty($FILES['name'])){
                $path = $FILES["tmp_name"];
                $object = PHPExcel_IOFactory::load($path);
                $params = array();
                
                //case: การอัพโหลดไฟล์ excel ถ้าลืมใส่ column ไหนให้บอกผิด row ไหน
                $EXCEL_HeaderCol = array("ID_Employee" => array("name"=> "ไอดีพนักงาน","status" => false,"error" => "ไม่พบข้อมูลคอลัมน์ ไอดีพนักงาน")
                    ,"Name_Employee" => array("name"=> "ชื่อพนักงาน","status" => false ,"error" => "ไม่พบข้อมูลคอลัมน์ ชื่อพนักงาน" )
                    ,"Surname_Employee" => array("name"=> "นามสกุลพนักงาน","status" => false ,"error" => "ไม่พบข้อมูลคอลัมน์ นามสกุลพนักงาน")
                    ,"Username_Employee" => array("name"=> "ชื่อผุ้ใช้","status" => false ,"error" => "ไม่พบข้อมูลคอลัมน์ ชื่อผุ้ใช้")
                    ,"Email_Employee" => array("name"=> "อีเมล์","status" => false ,"error" => "ไม่พบข้อมูลคอลัมน์ อีเมล์")
                    ,"Password_Employee" => array("name"=> "รหัสผ่าน","status" => false ,"error" => "ไม่พบข้อมูลคอลัมน์ รหัสผ่าน")
                    ,"User_Status_Employee" => array("name"=> "สถานะ","status" => false ,"error" => "ไม่พบข้อมูลคอลัมน์ สถานะ")
                );
                $count = 0;
                foreach ($object->getWorksheetIterator() as $worksheet) {
                    $highestRow = $worksheet->getHighestRow();
                    $highestColumn = $worksheet->getHighestColumn();
                    //  echo $highestRow;exit();
                    // row = 2 คือ row แรก ไม่รวม header
                    #เช็คหัวตารางชื่อตรงกันไหมใน array ที่ hardcode ไว้
                    if($count != 1){
                    for($col_ =0; $col_ < 7;$col_ ++){
                                $col__cc = strval($worksheet->getCellByColumnAndRow($col_, 1)->getValue());
                                if($col__cc == ''){
                                    $c = array_values($EXCEL_HeaderCol);
                                    $message = "มีบางอย่างผิดพลาด , กรุณาตรวจสอบข้อมูลไม่พบคอลัมน์  ".$c[$col_]['name'];
                                    return json_encode(array("status" => false , "message" => $message));  
                                    
                                }else{
                                    $ccc = array_key_exists($col__cc , $EXCEL_HeaderCol);
                                    if(!$ccc){                  
                                        $c = array_values($EXCEL_HeaderCol);
                                        $message = "มีบางอย่างผิดพลาด , กรุณาตรวจสอบข้อมูลไม่พบคอลัมน์  ".$c[$col_]['name'];
                                        return json_encode(array("status" => false , "message" => $message));  
                                    }
                                }
                            }
                            ++ $count;
                    }

                    #eof
                

                    for ($row = 2; $row <= $highestRow; $row++) {
                        if ($worksheet->getCellByColumnAndRow(0, $row)->getValue() != '') {
                            
                            $getCellArray = $this->checkemptycell($worksheet , $row);
                            if($getCellArray['status'] == false){
                                $c = array_values($EXCEL_HeaderCol);
                                $message = "มีบางอย่างผิดพลาด , กรุณาตรวจสอบข้อมูลไม่พบข้อมูลในแถวที่{$row}(รวมหัวตาราง) ในคอลัมน์คือ ".$c[$getCellArray["column"]]['name'] .'';
                                return json_encode(array("status" => false , "message" => $message));     
                            }

                            $push_array = array("ID_Employee" => $getCellArray["data"][0],
                                "Name_Employee" => $getCellArray["data"][1],
                                "Surname_Employee" => $getCellArray["data"][2],
                                "Username_Employee" => $getCellArray["data"][3],
                                "Email_Employee" => $getCellArray["data"][4],
                                "Password_Employee" => $getCellArray["data"][5],
                                "User_Status_Employee" => $getCellArray["data"][6]
                            );
                            array_push($params, $push_array);
                        }else{

                            
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

        # 
        return json_encode(array("status"=>true));
    }
    
    private function checkemptycell( $worksheet,$row){
        $push_array = array();
        for($i =0;$i < 7; $i++){
            if(empty($worksheet->getCellByColumnAndRow($i, $row)->getValue())){
                return array("status" => false , "column"=>$i ,"row" => $row);
            }else{
                $push_array[$i] = $worksheet->getCellByColumnAndRow($i, $row)->getValue();
            }
        }

        return array("status" => true , "data" => $push_array);
        
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

        $file_log = Filelog::findByPage('manage_user');
      
        include Router::getSourcePath() . "views/admin/manage_user.inc.php";
    }

}