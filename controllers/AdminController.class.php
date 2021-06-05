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
            case "import_excel_user":
                $FILES = isset($params["FILES"]["file"]) ? $params["FILES"]["file"] : "";
                $FILE_IMG = isset($params["FILES"]["examfile"]) ? $params["FILES"]["examfile"] : "";
                $result = $this->$action($params["POST"], $FILES, $FILE_IMG);
                echo $result;
                break;
            case "export_excel_test_user":
                $result = $this->$action($params["POST"]);
                echo $result;
                break;
            case "export_excel_user":
                $result = $this->$action($params["POST"]);
                echo $result;
                break;
            case "manage_company" :
                $this->$action();
                break;
            case "create_company" :
                $result = $this->$action($params["POST"]);
                echo $result;
                break;
            case "edit_company" :
                $ID_Company = isset($params["GET"]["ID_Company"]) ? $params["GET"]["ID_Company"] : "";
                $result = $this->$action($params["POST"], $ID_Company);
                echo $result;
                break;
            case "delete_company":
                $result = $this->$action($params["POST"]["ID_Company"]);
                echo $result;
                break;
            case "import_excel_company":
                $FILES = isset($params["FILES"]["file"]) ? $params["FILES"]["file"] : "";
                $FILE_IMG = isset($params["FILES"]["examfile"]) ? $params["FILES"]["examfile"] : "";
                $result = $this->$action($params["POST"], $FILES, $FILE_IMG);
                echo $result;
                break;
            case "findbyID_Company":
                $ID_Company = isset($params["POST"]["ID_Company"]) ? $params["POST"]["ID_Company"] : "";
                //print_r($ID_Company);exit();
                if (!empty($ID_Company)) {
                    $result = $this->$action($ID_Company);
                    echo $result;
                }
                break;
            case "getAmphur":
                $PROVINCE_ID = isset($params["POST"]["PROVINCE_ID"]) ? $params["POST"]["PROVINCE_ID"] : "";

                if (!empty($PROVINCE_ID)) {
                    $result = $this->$action($PROVINCE_ID);

                    echo $result;
                }
                break;
            case "export_excel_test_company":
                $result = $this->$action($params["POST"]);
                echo $result;
                break;
            case "manage_sales" :
                $this->$action();
                break;
            case "create_sales" :
                $result = $this->$action($params["POST"]);
                echo $result;
                break;
            case "edit_sales" :
                $ID_Excel = isset($params["GET"]["ID_Excel"]) ? $params["GET"]["ID_Excel"] : "";
                $result = $this->$action($params["POST"], $ID_Excel);
                echo $result;
                break;
            case "delete_sales":
                $result = $this->$action($params["POST"]["ID_Excel"]);
                echo $result;
                break;
            case "import_excel_sales":
                $FILES = isset($params["FILES"]["file"]) ? $params["FILES"]["file"] : "";
                $FILE_IMG = isset($params["FILES"]["examfile"]) ? $params["FILES"]["examfile"] : "";
                $result = $this->$action($params["POST"], $FILES, $FILE_IMG);
                echo $result;
                break;
            case "findbyID_Sales":
                $ID_Excel = isset($params["POST"]["ID_Excel"]) ? $params["POST"]["ID_Excel"] : "";

                if (!empty($ID_Excel)) {
                    $result = $this->$action($ID_Excel);
                    echo $result;
                }
                break;
            case "export_excel_test_sales":
                $result = $this->$action($params["POST"]);
                echo $result;
                break;
            case "manage_news" :
                $this->$action();
                break;
            case "create_news" :
                $FILE_IMG = isset($params["FILES"]["profile_news"]) ? $params["FILES"]["profile_news"] : "";
                $result = $this->$action($params["POST"], $FILE_IMG);
                echo $result;
                break;  
            case "findbyID_Message":
                $ID_Message = isset($params["POST"]["ID_Message"]) ? $params["POST"]["ID_Message"] : "";
                if (!empty($ID_Message)) {
                    $result = $this->$action($ID_Message);
                    echo $result;
                }
                break;
            case "edit_news":
                $FILE_IMG = isset($params["FILES"]) ? $params["FILES"] : "";
                $Params= isset($params["POST"]) ? $params["POST"] : "";
                $ID_Message = isset($params["GET"]["ID_Message"]) ? $params["GET"]["ID_Message"] : "";
                $result = $this->$action($params["POST"] ,$FILE_IMG, $ID_Message);
                echo $result;
                break;
            case "delete_news":
                $params = isset($params["GET"]["ID_Message"]) ? $params["GET"]["ID_Message"] : "";
                $result = $this->$action($params);
                // print_r($params);
                echo $result;
                break;
            case "manage_award" :
                $this->$action();
                break;
            case "create_award":
                $FILE_IMG = isset($params["FILES"]["award_pic"]) ? $params["FILES"]["award_pic"] : "";
                $result = $this->$action($params["POST"], $FILE_IMG);
                echo $result;
                break; 
            case "findAwardbyID_Award" :
                $ID_Award = isset($params["POST"]["ID_Award"]) ? $params["POST"]["ID_Award"] : "";
                if (!empty($ID_Award)) {
                    $result = $this->$action($ID_Award);
                    echo $result;
                }
                break;
            case "edit_award" :
                $FILE_IMG = isset($params["FILES"]) ? $params["FILES"] : "";
                $Params= isset($params["POST"]) ? $params["POST"] : "";
                $ID_Award = isset($params["GET"]["ID_Award"]) ? $params["GET"]["ID_Award"] : "";
                $result = $this->$action($params["POST"] ,$FILE_IMG, $ID_Award);
                echo $result;
                break;
            case "delete_award":
                $params = isset($params["GET"]["ID_Award"]) ? $params["GET"]["ID_Award"] : "";
                $result = $this->$action($params);
                // print_r($params);
                echo $result;
                    break;
            case "manage_promotion" :
                $this->$action();
                break;
            case "create_promotion" :
                $result = $this->$action($params["POST"]);
                echo $result;
                break;
            case "edit_promotion" :
                $ID_Promotion = isset($params["GET"]["ID_Promotion"]) ? $params["GET"]["ID_Promotion"] : "";
                $result = $this->$action($params["POST"], $ID_Promotion);
                echo $result;
                break;
            case "delete_promotion":
                $result = $this->$action($params["POST"]["ID_Promotion"]);
                echo $result;
                break;
            case "findbyID_Promotion":
                $ID_Promotion = isset($params["POST"]["ID_Promotion"]) ? $params["POST"]["ID_Promotion"] : "";

                if (!empty($ID_Promotion)) {
                    $result = $this->$action($ID_Promotion);
                    echo $result;
                }
                break;
            default:
                break;
        }

    }

    private function import_excel_user(array $params, array $FILES, array $FILE_IMG)
    {
        $excel = new Excel();
        #UPLOAD IMAGE
        if (!empty($FILE_IMG) && !empty($FILE_IMG['name'])) {
            # update new pic
            $target_file_img = Router::getSourcePath() . "images/" . $FILE_IMG['name'];

            if (!empty($FILE_IMG) && isset($FILE_IMG['name'])) {
                if (!empty($FILE_IMG['name'])) {
                    move_uploaded_file($FILE_IMG["tmp_name"], $target_file_img);

                    $employee_ = new Employee();
                    $employee_->file_log($FILE_IMG['name'], 1);
                }
            }

        }

        #UPLOAD EXCEL

        if (!empty($FILES) && !empty($FILES['name'])) {
            $path = $FILES["tmp_name"];
            $object = PHPExcel_IOFactory::load($path);
            $params = array();

            //case: การอัพโหลดไฟล์ excel ถ้าลืมใส่ column ไหนให้บอกผิด row ไหน
            $EXCEL_HeaderCol = array("ID_Employee" => array("name" => "ไอดีพนักงาน", "status" => false, "error" => "ไม่พบข้อมูลคอลัมน์ ไอดีพนักงาน")
            , "Name_Employee" => array("name" => "ชื่อพนักงาน", "status" => false, "error" => "ไม่พบข้อมูลคอลัมน์ ชื่อพนักงาน")
            , "Surname_Employee" => array("name" => "นามสกุลพนักงาน", "status" => false, "error" => "ไม่พบข้อมูลคอลัมน์ นามสกุลพนักงาน")
            , "Username_Employee" => array("name" => "ชื่อผุ้ใช้", "status" => false, "error" => "ไม่พบข้อมูลคอลัมน์ ชื่อผุ้ใช้")
            , "Email_Employee" => array("name" => "อีเมล์", "status" => false, "error" => "ไม่พบข้อมูลคอลัมน์ อีเมล์")
            , "Password_Employee" => array("name" => "รหัสผ่าน", "status" => false, "error" => "ไม่พบข้อมูลคอลัมน์ รหัสผ่าน")
            , "User_Status_Employee" => array("name" => "สถานะ", "status" => false, "error" => "ไม่พบข้อมูลคอลัมน์ สถานะ")
            );
            $count = 0;
            foreach ($object->getWorksheetIterator() as $worksheet) {
                $highestRow = $worksheet->getHighestRow();
                $highestColumn = $worksheet->getHighestColumn();
                //  echo $highestRow;exit();
                // row = 2 คือ row แรก ไม่รวม header
                #เช็คหัวตารางชื่อตรงกันไหมใน array ที่ hardcode ไว้
                if ($count != 1) {
                    for ($col_ = 0; $col_ < 7; $col_++) {
                        $col__cc = strval($worksheet->getCellByColumnAndRow($col_, 1)->getValue());
                        if ($col__cc == '') {
                            $c = array_values($EXCEL_HeaderCol);
                            $message = "มีบางอย่างผิดพลาด , กรุณาตรวจสอบข้อมูลไม่พบคอลัมน์  " . $c[$col_]['name'];
                            return json_encode(array("status" => false, "message" => $message));

                        } else {
                            $ccc = array_key_exists($col__cc, $EXCEL_HeaderCol);
                            if (!$ccc) {
                                $c = array_values($EXCEL_HeaderCol);
                                $message = "มีบางอย่างผิดพลาด , กรุณาตรวจสอบข้อมูลไม่พบคอลัมน์  " . $c[$col_]['name'];
                                return json_encode(array("status" => false, "message" => $message));
                            }
                        }
                    }
                    ++$count;
                }

                #eof

              
                for ($row = 2; $row <= $highestRow; $row++) {
                    
                    if ($worksheet->getCellByColumnAndRow(0, $row)->getValue() != '') {
                      
                        $getCellArray = $this->checkemptycell_user($worksheet, $row);
                      
                        if ($getCellArray['status'] == false) {
                            $c = array_values($EXCEL_HeaderCol);
                            $message = "มีบางอย่างผิดพลาด , กรุณาตรวจสอบข้อมูลไม่พบข้อมูลในแถวที่{$row}(รวมหัวตาราง) ในคอลัมน์คือ " . $c[$getCellArray["column"]]['name'] . '';
                            return json_encode(array("status" => false, "message" => $message));
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
                    } else {
                        
                        $getCellArray = $this->checkemptycell_user($worksheet, $row);
                      
                        if ($getCellArray['status'] == false) {
                            $c = array_values($EXCEL_HeaderCol);
                            $message = "มีบางอย่างผิดพลาด , กรุณาตรวจสอบข้อมูลไม่พบข้อมูลในแถวที่{$row}(รวมหัวตาราง) ในคอลัมน์คือ " . $c[$getCellArray["column"]]['name'] . '';
                            return json_encode(array("status" => false, "message" => $message));
                        }

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
        return json_encode(array("status" => true));
    }

    private function checkemptycell_user($worksheet, $row)
    {
        $push_array = array();
        for ($i = 0; $i < 7; $i++) {
            if (empty($worksheet->getCellByColumnAndRow($i, $row)->getValue())) {
                return array("status" => false, "column" => $i, "row" => $row);
            } else {
                $push_array[$i] = $worksheet->getCellByColumnAndRow($i, $row)->getValue();
            }
        }

        return array("status" => true, "data" => $push_array);

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
    private function import_excel_company(array $params, array $FILES, array $FILE_IMG)
    {
        $excel = new Excel();
        #UPLOAD IMAGE
        if (!empty($FILE_IMG) && !empty($FILE_IMG['name'])) {
            # update new pic
            $target_file_img = Router::getSourcePath() . "images/" . $FILE_IMG['name'];

            if (!empty($FILE_IMG) && isset($FILE_IMG['name'])) {
                if (!empty($FILE_IMG['name'])) {
                    move_uploaded_file($FILE_IMG["tmp_name"], $target_file_img);

                    $company_ = new Company();
                    $company_->file_log($FILE_IMG['name'], 2);
                }
            }

        }
        #UPLOAD EXCEL

        if (!empty($FILES) && !empty($FILES['name'])) {
            $path = $FILES["tmp_name"];
            $object = PHPExcel_IOFactory::load($path);
            $params = array();

            //case: การอัพโหลดไฟล์ excel ถ้าลืมใส่ column ไหนให้บอกผิด row ไหน
            $EXCEL_HeaderCol = array("ID_Company" => array("name" => "ไอดีบริษัท", "status" => false, "error" => "ไม่พบข้อมูลคอลัมน์ ไอดีบริษัท")
            , "Name_Company" => array("name" => "ชื่อบริษัท", "status" => false, "error" => "ไม่พบข้อมูลคอลัมน์ ชื่อบริษัท")
            , "Address_Company" => array("name" => "ที่อยู่บริษัท", "status" => false, "error" => "ไม่พบข้อมูลคอลัมน์ ที่อยู่บริษัท")
            , "PROVINCE_ID" => array("name" => "ไอดีจังหวัด", "status" => false, "error" => "ไม่พบข้อมูลคอลัมน์ ไอดีจังหวัด")
            , "AMPHUR_ID" => array("name" => "ไอดีอำเภอ", "status" => false, "error" => "ไม่พบข้อมูลคอลัมน์ ไอดีอำเภอ")
            , "Tel_Company" => array("name" => "เบอร์บริษัท", "status" => false, "error" => "ไม่พบข้อมูลคอลัมน์ เบอร์บริษัท")
            , "Email_Company" => array("name" => "อีเมล์บริษัท", "status" => false, "error" => "ไม่พบข้อมูลคอลัมน์ อีเมล์บริษัท")
            , "Tax_Number_Company" => array("name" => "เลขผู้เสียภาษี", "status" => false, "error" => "ไม่พบข้อมูลคอลัมน์ เลขผู้เสียภาษี")
            , "Credit_Limit_Company" => array("name" => "วงเงินสูงสุด", "status" => false, "error" => "ไม่พบข้อมูลคอลัมน์ วงเงินสูงสุด")
            , "Credit_Term_Company" => array("name" => "เครดิตเทอม", "status" => false, "error" => "ไม่พบข้อมูลคอลัมน์ เครดิตเทอม")
            , "Cluster_Shop" => array("name" => "คลัสเตอร์", "status" => false, "error" => "ไม่พบข้อมูลคอลัมน์ คลัสเตอร์")
            , "Contact_Name_Company" => array("name" => "ชื่อที่ติดต่อ", "status" => false, "error" => "ไม่พบข้อมูลคอลัมน์ ชื่อที่ติดต่อ")
            , "IS_Blacklist" => array("name" => "บัญชีดำ", "status" => false, "error" => "ไม่พบข้อมูลคอลัมน์ บัญชีดำ")
            , "Cause_Blacklist" => array("name" => "สาเหตุที่ติดบัญชีดำ", "status" => false, "error" => "ไม่พบข้อมูลคอลัมน์ สาเหตุที่ติดบัญชีดำ")
            );
            $count = 0;
            foreach ($object->getWorksheetIterator() as $worksheet) {
                $highestRow = $worksheet->getHighestRow();
                $highestColumn = $worksheet->getHighestColumn();
                //  echo $highestRow;exit();
                // row = 2 คือ row แรก ไม่รวม header
                #เช็คหัวตารางชื่อตรงกันไหมใน array ที่ hardcode ไว้
                if ($count != 1) {
                    for ($col_ = 0; $col_ < 14; $col_++) {
                        $col__cc = strval($worksheet->getCellByColumnAndRow($col_, 1)->getValue());
                        if ($col__cc == '') {
                            $c = array_values($EXCEL_HeaderCol);
                            $message = "มีบางอย่างผิดพลาด , กรุณาตรวจสอบข้อมูลไม่พบคอลัมน์  " . $c[$col_]['name'];
                            return json_encode(array("status" => false, "message" => $message));

                        } else {
                            $ccc = array_key_exists($col__cc, $EXCEL_HeaderCol);
                            if (!$ccc) {
                                $c = array_values($EXCEL_HeaderCol);
                                $message = "มีบางอย่างผิดพลาด , กรุณาตรวจสอบข้อมูลไม่พบคอลัมน์  " . $c[$col_]['name'];
                                return json_encode(array("status" => false, "message" => $message));
                            }
                        }
                    }
                    ++$count;
                }

                #eof
                for ($row = 2; $row <= $highestRow; $row++) {
                    if ($worksheet->getCellByColumnAndRow(0, $row)->getValue() != '') {
                        $getCellArray = $this->checkemptycell_company($worksheet, $row);
                        if ($getCellArray['status'] == false) {
                            $c = array_values($EXCEL_HeaderCol);
                            $message = "มีบางอย่างผิดพลาด , กรุณาตรวจสอบข้อมูลไม่พบข้อมูลในแถวที่{$row}(รวมหัวตาราง) ในคอลัมน์คือ " . $c[$getCellArray["column"]]['name'] . '';
                            return json_encode(array("status" => false, "message" => $message));
                        }


                        $push_array = array("ID_Company" => $getCellArray["data"][0],
                            "Name_Company" => $getCellArray["data"][1],
                            "Address_Company" => $getCellArray["data"][2],
                            "PROVINCE_ID" => $getCellArray["data"][3],
                            "AMPHUR_ID" => $getCellArray["data"][4],
                            "Tel_Company" => $getCellArray["data"][5],
                            "Email_Company" => $getCellArray["data"][6],
                            "Tax_Number_Company" => $getCellArray["data"][7],
                            "Credit_Limit_Company" => $getCellArray["data"][8],
                            "Credit_Term_Company" => $getCellArray["data"][9],
                            "Cluster_Shop" => $getCellArray["data"][10],
                            "Contact_Name_Company" => $getCellArray["data"][11],
                            "IS_Blacklist" => $getCellArray["data"][12],
                            "Cause_Blacklist" => $getCellArray["data"][13]
                        );
                        array_push($params, $push_array);
                    } else {


                    }
                }
            }
            // # create user ใหม่
            $company_ = new Company();
            $result = $company_->create_company_at_once($params);
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
        return json_encode(array("status" => true));
    }

    private function checkemptycell_company($worksheet, $row)
    {
        $push_array = array();
        for ($i = 0; $i < 14; $i++) {
            if (empty($worksheet->getCellByColumnAndRow($i, $row)->getValue())) {
                return array("status" => false, "column" => $i, "row" => $row);
            } else {
                $push_array[$i] = $worksheet->getCellByColumnAndRow($i, $row)->getValue();
            }
        }

        return array("status" => true, "data" => $push_array);

    }

    private function getAmphur($PROVINCE_ID){
        $access_company = new Company();
        $amphur_result = $access_company->getAmphur(
            $PROVINCE_ID
        );

        echo json_encode($amphur_result);

    }

    private function create_company($params)
    {
        # สร้างบริษัทลูกค้า
        $access_company = new Company();
        $company_result = $access_company->create_company(
            $params
        );
        return json_encode($company_result);
    }

    private function edit_company($params, $ID_Company)
    {
        # อัปเดตบริษัทลูกค้า
        $access_company = new Company();
        $company_result = $access_company->edit_company(
            $params, $ID_Company
        );
        echo json_encode($company_result);

    }

    private function delete_company($ID_Company)
    {
        # ลบบริษัทลูกค้า
        $access_company = new Company();
        $company_result = $access_company->delete_company(
            $ID_Company
        );
        return json_encode($company_result);
    }

    private function findbyID_Company(string $ID_Company)
    {
        $company = Company::findById($ID_Company);//echo json_encode($employee);

        $data_sendback = array(
            "ID_Company" => $company->getID_Company(),
            "Name_Company" => $company->getName_Company(),
            "Address_Company" => $company->getAddress_Company(),
            "PROVINCE_ID" => $company->getPROVINCE_ID(),
            "AMPHUR_ID" => $company->getAMPHUR_ID(),
            "Tel_Company" => $company->getTel_Company(),
            "Email_Company" => $company->getEmail_Company(),
            "Tax_Number_Company" => $company->getTax_Number_Company(),
            "Credit_Limit_Company" => $company->getCredit_Limit_Company(),
            "Credit_Term_Company" => $company->getCredit_Term_Company(),
            "Cluster_Shop" => $company->getCluster_Shop(),
            "Contact_Name_Company" => $company->getContact_Name_Company(),
            "IS_Blacklist" => $company->getIS_Blacklist(),
            "Cause_Blacklist" => $company->getCause_Blacklist(),

        );
        echo json_encode(array("data" => $data_sendback));

    }
    private function import_excel_sales(array $params, array $FILES, array $FILE_IMG)
    {
        {
            $excel = new Excel();
            #UPLOAD IMAGE
            if (!empty($FILE_IMG) && !empty($FILE_IMG['name'])) {
                # update new pic
                $target_file_img = Router::getSourcePath() . "images/" . $FILE_IMG['name'];

                if (!empty($FILE_IMG) && isset($FILE_IMG['name'])) {
                    if (!empty($FILE_IMG['name'])) {
                        move_uploaded_file($FILE_IMG["tmp_name"], $target_file_img);

                        $sales_ = new Sales();
                        $sales_->file_log($FILE_IMG['name'], 3);
                    }
                }

            }
            #UPLOAD EXCEL
            date_default_timezone_set('Asia/Bangkok');
            if (!empty($FILES) && !empty($FILES['name'])) {
                $path = $FILES["tmp_name"];
                $object = PHPExcel_IOFactory::load($path);
                $params = array();

                //case: การอัพโหลดไฟล์ excel ถ้าลืมใส่ column ไหนให้บอกผิด row ไหน
                $EXCEL_HeaderCol = array("Date_Sales" => array("name" => "วันที่ขาย", "status" => false, "error" => "ไม่พบข้อมูลคอลัมน์ วันที่ขาย")
                , "ID_Company" => array("name" => "ไอดีบริษัทลูกค้า", "status" => false, "error" => "ไม่พบข้อมูลคอลัมน์ ไอดีบริษัทลูกค้า")
                , "ID_Employee" => array("name" => "ไอดีพนักงาน", "status" => false, "error" => "ไม่พบข้อมูลคอลัมน์ ไอดีพนักงาน")
                , "Result_Sales" => array("name" => "ยอดขาย", "status" => false, "error" => "ไม่พบข้อมูลคอลัมน์ ยอดขาย")
                );
                $count = 0;
                foreach ($object->getWorksheetIterator() as $worksheet) {
                    $highestRow = $worksheet->getHighestRow();
                    $highestColumn = $worksheet->getHighestColumn();
                    //  echo $highestRow;exit();
                    // row = 2 คือ row แรก ไม่รวม header
                    #เช็คหัวตารางชื่อตรงกันไหมใน array ที่ hardcode ไว้
                    if ($count != 1) {
                        for ($col_ = 0; $col_ < 4; $col_++) {
                            $col__cc = strval($worksheet->getCellByColumnAndRow($col_, 1)->getValue());
                            if ($col__cc == '') {
                                $c = array_values($EXCEL_HeaderCol);
                                $message = "มีบางอย่างผิดพลาด , กรุณาตรวจสอบข้อมูลไม่พบคอลัมน์  " . $c[$col_]['name'];
                                return json_encode(array("status" => false, "message" => $message));

                            } else {
                                $ccc = array_key_exists($col__cc, $EXCEL_HeaderCol);
                                if (!$ccc) {
                                    $c = array_values($EXCEL_HeaderCol);
                                    $message = "มีบางอย่างผิดพลาด , กรุณาตรวจสอบข้อมูลไม่พบคอลัมน์  " . $c[$col_]['name'];
                                    return json_encode(array("status" => false, "message" => $message));
                                }
                            }
                        }
                        ++$count;
                    }

                    #eof


                    for ($row = 2; $row <= $highestRow; $row++) {
                        if ($worksheet->getCellByColumnAndRow(0, $row)->getValue() != '') {
                            $getCellArray = $this->checkemptycell_sales($worksheet, $row);
                            if ($getCellArray['status'] == false) {
                                $c = array_values($EXCEL_HeaderCol);
                                $message = "มีบางอย่างผิดพลาด , กรุณาตรวจสอบข้อมูลไม่พบข้อมูลในแถวที่{$row}(รวมหัวตาราง) ในคอลัมน์คือ " . $c[$getCellArray["column"]]['name'] . '';
                                return json_encode(array("status" => false, "message" => $message));
                            }
                            $strStartDate = "1900-01-01";
                            //$date = $getCellArray["data"][0];
                            //$date = PHPExcel_Shared_Date::ExcelToPHP( $getCellArray["data"][0]);
                            $date = PHPExcel_Style_NumberFormat::toFormattedString($getCellArray["data"][0], "D/M/YYYY");
                            

                            $push_array = array(//"ID_Excel" => $ID_Excel,
                                "Date_Sales" => $date,
                                "ID_Company" => $getCellArray["data"][1],
                                "ID_Employee" => $getCellArray["data"][2],
                                "Result_Sales" => $getCellArray["data"][3],
                            );
                            array_push($params, $push_array);
                          
                        } else {


                        }
                    }

                }
                // # create sales ใหม่
                $sales_ = new Sales();
                $result = $sales_->create_sales_at_once($params);
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
            return json_encode(array("status" => true));
        }
    }

    private function checkemptycell_sales($worksheet, $row)
    {
        $push_array = array();
        for ($i = 0; $i < 4; $i++) {
            if (empty($worksheet->getCellByColumnAndRow($i, $row)->getValue())) {
                return array("status" => false, "column" => $i, "row" => $row);
            } else {
                $push_array[$i] = $worksheet->getCellByColumnAndRow($i, $row)->getValue();
            }
        }

        return array("status" => true, "data" => $push_array);

    }

    private function create_sales($params)
    {
        # สร้างยอดขาย
        $access_sales = new Sales();
      
        $sales_result = $access_sales->create_sales(
            $params
        );
        return json_encode($sales_result);
    }

    private function edit_sales($params, $ID_Excel)
    {
        # อัปเดตยอดขาย
        $access_sales = new Sales();
        $sales_result = $access_sales->edit_sales(
            $params, $ID_Excel
        );
        echo json_encode($sales_result);

    }

    private function delete_sales($ID_Excel)
    {
        # ลบยอดขาย
        $access_sales = new Sales();
        $sales_result = $access_sales->delete_sales(
            $ID_Excel
        );
        return json_encode($sales_result);
    }

    private function findbyID_Sales(string $ID_Excel)
    {
        $sales = Sales::findById($ID_Excel);//echo json_encode($sales);


        $data_sendback = array(
            "ID_Excel" => $sales->getID_Excel(),
            "Date_Sales" => $sales->getDate_Sales(),
            "ID_Company" => $sales->getID_Company(),
            "ID_Employee" => $sales->getID_Employee(),
            "Result_Sales" => $sales->getResult_Sales(),

        );
        echo json_encode(array("data" => $data_sendback));

    }
    private static function create_news($params, $FILE_IMG)
    {
        // # สร้างข่าวสารร
        $access_news = new Message();
        $messageid = $access_news->geneateDateTimemd() ;
        $message_title =  $params["Tittle_Message"] ;
        $message_text  =  isset($params["Text_Message"]) ?  $params["Text_Message"] : "";

        // print_r('hello world'. '     ' . $access_news->generatePictureFilename($FILE_IMG['name'][0], $message_title));

        $message_filename = !empty($FILE_IMG) ?  $access_news->generatePictureFilename($FILE_IMG['name'][0], $message_title) : "" ;
        $message_datetime = $access_news->geneateDateTime();
        $locate_img = "";

        if (!empty($FILE_IMG) && !empty($FILE_IMG['name']))
        {
            $name_file =  $FILE_IMG['name'][0];
            $name_file_type =  explode('.',$name_file)[1] ;
            $tmp_name =  $FILE_IMG['tmp_name'][0];
            $locate_img = Router::getSourcePath() . "images/" . $message_filename . ".".$name_file_type;

            // copy original file to destination file
            move_uploaded_file($tmp_name, $locate_img);
        }

        $access_news_params = array(
            "ID_Message" => $messageid,
            "Tittle_Message" => $message_title,
            "Text_Message" => $message_text,
            "Picture_Message" => $locate_img,
            "Date_Message"=> $message_datetime,
        );

        $result = $access_news->create_news(
            $access_news_params
        );

        return json_encode($result);
    }

    private function findbyID_Message($findbyID_Message)
    {
        $message = Message::findById($findbyID_Message);//echo json_encode($employee);

        // echo json_encode(array("data" => $data_sendback));

        $data_sendback = array(
            "ID_Message" => $message->getID_Message(),
            "Tittle_Message" => $message->getTittle_Message(),
            "Text_Message" => $message->getText_Message(),
            "Picture_Message" => $message->getPicture_Message(),
            "Date_Message" => $message->getDate_Message(),
        );

        echo json_encode(array("data" => $data_sendback));

    }

    private function edit_news($params, $FILE_IMG, $ID_Message)
    {

        // # สร้างข่าวสารร
        $access_news = new Message();
        $messageid = $ID_Message ;
        $message_title =  $params["Tittle_Message"] ;
        $message_text  =  isset($params["Text_Message"]) ?  $params["Text_Message"] : "";
        $message_datetime = $access_news->geneateDateTime();

        $locate_img = "";

        // print_r('hello world'. '     ' . $access_news->generatePictureFilename($FILE_IMG['profile_news']['name'][0], $message_title));

        $message_filename = !empty($FILE_IMG) ?  $access_news->generatePictureFilename($FILE_IMG['profile_news']['name'][0], $message_title) : "" ;
        if (!empty($FILE_IMG) && !empty($FILE_IMG['profile_news']['name']))
        {
            $name_file =  $FILE_IMG['profile_news']['name'][0];
            $name_file_type =  explode('.',$name_file)[1] ;
            $tmp_name =  $FILE_IMG['profile_news']['tmp_name'][0];
            $locate_img = Router::getSourcePath() . "images/" . $message_filename . ".".$name_file_type;

            // copy original file to destination file
            move_uploaded_file($tmp_name, $locate_img);
        }

        $access_news_params = array(
            "ID_Message" => $messageid,
            "Tittle_Message" => $message_title,
            "Text_Message" => $message_text,
            "Picture_Message" => $locate_img,
            "Date_Message"=> $message_datetime,
        );


        $result = $access_news->update_news(
            $access_news_params
        );

        return json_encode($result);
    }

    private function delete_news($params) {
        $access_message = new Message();
        $result = $access_message->delete_news(
            $params
        );
        return json_encode($result);
    }
    private function create_award($params, $FILE_IMG)
    {
        $access_award = new Award();

        // # สร้างข่าวสารร
        $awardid = $access_award->geneateDateTimemd() ;
        $award_title =  $params["Tittle_Award"] ;
        $award_filename = !empty($FILE_IMG) ?  $access_award->generatePictureFilename($FILE_IMG['name'][0], $award_title) : "" ;
        $award_datetime = $access_award->geneateDateTime();
        $locate_img = "";
        $award_ID_Employee = $params["ID_Employee"];

        if (!empty($FILE_IMG) && !empty($FILE_IMG['name']))
        {
            $name_file =  $FILE_IMG['name'][0];
            $name_file_type =  explode('.',$name_file)[1] ;
            $tmp_name =  $FILE_IMG['tmp_name'][0];
            $locate_img = Router::getSourcePath() . "images/" . $award_filename . ".".$name_file_type;

            // copy original file to destination file
            move_uploaded_file($tmp_name, $locate_img);
        }

        $access_award_params = array(
            "ID_Award" => $awardid,
            "Tittle_Award" => $award_title,
            "Picture_Award" => $locate_img,
            "Date_Award"=> $award_datetime,
            "ID_Employee" => $award_ID_Employee,
        );

        $result = $access_award->create_award(
            $access_award_params
        );

        return json_encode($result);
    }



    private function findAwardbyID_Award($findbyID_Award)
    {
        $award = Award::findAward_byID($findbyID_Award);//echo json_encode($employee);

        // echo json_encode(array("data" => $data_sendback));

        $data_sendback = array(
            "ID_Award" => $award->getID_Award(),
            "Tittle_Award" => $award->getTittle_Award(),
            "Picture_Award" => $award->getPicture_Award(),
            "Date_Award" => $award->getDate_Award(),
            "ID_Employee" => $award->getID_Employee(),
        );

        echo json_encode(array("data" => $data_sendback));
    }


    private function edit_award($params, $FILE_IMG, $ID_Award)
    {

        // # สร้างข่าวสารร
        $access_award = new Award();
        $awardid = $ID_Award ;
        $award_title =  $params["Tittle_Award"] ;
        $award_datetime = $access_award->geneateDateTime();

        $locate_img = "";

        // print_r('hello world'. '     ' . $access_news->generatePictureFilename($FILE_IMG['profile_news']['name'][0], $message_title));

        $award_filename = !empty($FILE_IMG) ?  $access_award->generatePictureFilename($FILE_IMG['award_pic']['name'][0], $award_title) : "" ;
        if (!empty($FILE_IMG) && !empty($FILE_IMG['award_pic']['name']))
        {
            $name_file =  $FILE_IMG['award_pic']['name'][0];
            $name_file_type =  explode('.',$name_file)[1] ;
            $tmp_name =  $FILE_IMG['award_pic']['tmp_name'][0];
            $locate_img = Router::getSourcePath() . "images/" . $award_filename . ".".$name_file_type;

            // copy original file to destination file
            move_uploaded_file($tmp_name, $locate_img);
        }

        $access_award_params = array(
            "ID_Award" => $awardid,
            "Tittle_Award" => $award_title,
            "Picture_Award" => $locate_img,
            "Date_Award"=> $award_datetime,
        );


        $result = $access_award->update_award(
            $access_award_params
        );

        return json_encode($result);

    }

    private function delete_award($params) {
        $access_award = new Award();
        $result = $access_award->delete_award(
            $params
        );
        // print_r($result);
        return json_encode($result);
    }

    private function create_promotion($params)
    {
        # สร้างสินค้าส่งเสริมการขาย
        $access_promotion = new Promotion();

        $promotion_result = $access_promotion->create_promotion(
            $params
        );
        return json_encode($promotion_result);
    }

    private function edit_promotion($params, $ID_Promotion)
    {
        # อัปเดตสินค้าส่งเสริมการขาย
        $access_promotion = new Promotion();
        $promotion_result = $access_promotion->edit_promotion(
            $params, $ID_Promotion
        );
        echo json_encode($promotion_result);

    }

    private function delete_promotion($ID_Promotion)
    {
        # ลบสินค้าส่งเสริมการขาย
        $access_promotion = new Promotion();
        $promotion_result = $access_promotion->delete_promotion(
            $ID_Promotion
        );
        return json_encode($sales_result);
    }

    private function findbyID_Promotion(string $ID_Promotion)
    {
        $promotion = Promotion::findById($ID_Promotion);//echo json_encode($sales);


        $data_sendback = array(
            "ID_Promotion" => $promotion->getID_Promotion(),
            "Name_Promotion" => $promotion->getName_Promotion(),
            "Unit_Promotion" => $promotion->getUnit_Promotion(),
            "Price_Unit_Promotion" => $promotion->getPrice_Unit_Promotion(),

        );
        echo json_encode(array("data" => $data_sendback));

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

    //หน้า export ไฟล์ตัวอย่าง excel ผู้ใช้
    private function export_excel_test_user($params = null)
    {
        $exportExcel = new Employee();
        $exportExcelEmployee = Employee::findAll();

        try {
            // ob_end_clean(); 

            // เรียนกใช้ PHPExcel
            $objPHPExcel = new PHPExcel();
            // กำหนดค่าต่างๆ ของเอกสาร excel
            $objPHPExcel->getProperties()->setCreator("bp.com")
                ->setLastModifiedBy("bp.com")
                ->setTitle("PHPExcel Test Document")
                ->setSubject("PHPExcel Test Document")
                ->setDescription("Test document for PHPExcel, generated using PHP classes.")
                ->setKeywords("office PHPExcel php")
                ->setCategory("Test result file");

            // กำหนดชื่อให้กับ worksheet ที่ใช้งาน
            $objPHPExcel->getActiveSheet()->setTitle('Report');

            // กำหนด worksheet ที่ต้องการให้เปิดมาแล้วแสดง ค่าจะเริ่มจาก 0 , 1 , 2 , ......
            $objPHPExcel->setActiveSheetIndex(0);

            // การจัดรูปแบบของ cell
            $objPHPExcel->getDefaultStyle()
                ->getAlignment()
                ->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP)
                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            //HORIZONTAL_CENTER //VERTICAL_CENTER

            // จัดความกว้างของคอลัมน์
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);

            // กำหนดหัวข้อให้กับแถวแรก
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1', 'ID_Employee')
                ->setCellValue('B1', 'Name_Employee')
                ->setCellValue('C1', 'Surname_Employee')
                ->setCellValue('D1', 'Username_Employee')
                ->setCellValue('E1', 'Email_Employee')
                ->setCellValue('F1', 'Password_Employee')
                ->setCellValue('G1', 'User_Status_Employee');

            $start_row = 2;
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A' . $start_row, "x99")
                ->setCellValue('B' . $start_row, "firstname")
                ->setCellValue('C' . $start_row, "lastname")
                ->setCellValue('D' . $start_row, "username")
                ->setCellValue('E' . $start_row, "exam@gmail.com")
                ->setCellValue('F' . $start_row, "example123E$")
                ->setCellValue('G' . $start_row, "Admin");

            $i = 0;

            $filename = 'User-' . date("dmYHis") . '.xlsx'; //  กำหนดชือ่ไฟล์ นามสกุล xls หรือ xlsx

            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');  // Excel2007 (xlsx) หรือ Excel5 (xls)
            ob_clean();

            $objWriter->save('./uploads/' . $filename);

            //download
            header('Content-Type: application/octet-stream');
            header("Content-Transfer-Encoding: Binary");
            header("Content-disposition: attachment; filename=\"" . $filename . "\"");
            echo file_get_contents("./uploads/" . $filename);
            die;


            return json_encode(array('status' => true, "filename" => $filename));
            //ob_end_clean();

            // die($objWriter);
            //die;


        } catch (Exception $e) {
            // status that return to frontend
            $status = false;
            // error message handle
            $message = $e->getMessage();
        }


        return json_encode(array('status' => true));
    }
    //หน้า export ไฟล์ตัวอย่าง excel ผู้ใช้
    private function export_excel_user($params = null)
    {
        $exportExcel = new Employee();
        $exportExcelEmployee = Employee::findAll();

        try {
            // เรียนกใช้ PHPExcel
            $objPHPExcel = new PHPExcel();
            // กำหนดค่าต่างๆ ของเอกสาร excel
            $objPHPExcel->getProperties()->setCreator("bp.com")
                ->setLastModifiedBy("bp.com")
                ->setTitle("PHPExcel Test Document")
                ->setSubject("PHPExcel Test Document")
                ->setDescription("Test document for PHPExcel, generated using PHP classes.")
                ->setKeywords("office PHPExcel php")
                ->setCategory("Test result file");

            // กำหนดชื่อให้กับ worksheet ที่ใช้งาน
            $objPHPExcel->getActiveSheet()->setTitle('Report');

            // กำหนด worksheet ที่ต้องการให้เปิดมาแล้วแสดง ค่าจะเริ่มจาก 0 , 1 , 2 , ......
            $objPHPExcel->setActiveSheetIndex(0);

            // การจัดรูปแบบของ cell
            $objPHPExcel->getDefaultStyle()
                ->getAlignment()
                ->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP)
                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            //HORIZONTAL_CENTER //VERTICAL_CENTER

            // จัดความกว้างของคอลัมน์
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);

            // กำหนดหัวข้อให้กับแถวแรก
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1', 'ไอดีพนักงาน')
                ->setCellValue('B1', 'ชื่อ')
                ->setCellValue('C1', 'นามสกุล')
                ->setCellValue('D1', 'ชื่อผู้ใช้')
                ->setCellValue('E1', 'อีเมล์')
                ->setCellValue('F1', 'สถานะ');


            $start_row = 2;

            if (!empty($exportExcelEmployee)) {
                $i = 0;

                foreach ($exportExcelEmployee as $i => $result_array) {
                    // หากอยากจัดข้อมูลราคาให้ชิดขวา
                    $objPHPExcel->getActiveSheet()
                        ->getStyle('C' . $start_row)
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                    // หากอยากจัดให้รหัสสินค้ามีเลย 0 ด้านหน้า และแสดง 3     หลักเช่น 001 002
                    // $objPHPExcel->getActiveSheet()
                    // 	->getStyle('B'.$start_row)
                    // 	->getNumberFormat()
                    // 	->setFormatCode('000');

                    // เพิ่มข้อมูลลงแต่ละเซลล์
                    if (isset($exportExcelEmployee[$i])) {

                        $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('A' . $start_row, $exportExcelEmployee[$i]->getID_Employee())
                            ->setCellValue('B' . $start_row, $exportExcelEmployee[$i]->getName_Employee())
                            ->setCellValue('C' . $start_row, $exportExcelEmployee[$i]->getSurname_Employee())
                            ->setCellValue('D' . $start_row, $exportExcelEmployee[$i]->getUsername_Employee())
                            ->setCellValue('E' . $start_row, $exportExcelEmployee[$i]->getEmail_Employee())
                            ->setCellValue('F' . $start_row, $exportExcelEmployee[$i]->getUsername_Employee());
                    }

                    ++$start_row;
                }
                // กำหนดรูปแบบของไฟล์ที่ต้องการเขียนว่าเป็นไฟล์ excel แบบไหน ในที่นี้เป้นนามสกุล xlsx  ใช้คำว่า Excel2007
                // แต่หากต้องการกำหนดเป็นไฟล์ xls ใช้กับโปรแกรม excel รุ่นเก่าๆ ได้ ให้กำหนดเป็น  Excel5
                ob_start();
                $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');  // Excel2007 (xlsx) หรือ Excel5 (xls)

                $filename = 'User-' . date("dmYHi") . '.xlsx'; //  กำหนดชือ่ไฟล์ นามสกุล xls หรือ xlsx
                // บังคับให้ทำการดาวน์ดหลดไฟล์
                header('Content-Type: application/vnd.ms-excel'); //mime type
                header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
                header('Cache-Control: max-age=0'); //no cache
                ob_end_clean();
                $objWriter->save('php://output'); // ดาวน์โหลดไฟล์รายงาน
                //die($objWriter);

            } else {
                // status that return to frontend
                $status = false;
                // error message handle
                $message = "ไม่พบข้อมูล";
            }

        } catch (Exception $e) {
            // status that return to frontend
            $status = false;
            // error message handle
            $message = $e->getMessage();
        }


        return json_encode(array('status' => true));
    }
    //หน้าจัดการบริษัทลูกค้า
    private function manage_company($params = null)
    {
        session_start();
        $employee = $_SESSION["employee"];
        # retrieve data
        $company = Company::findAll();

        $file_log = Filelog::findByPage('manage_company');
        $provinceList = Province::findAll();
        $amphurList = Amphur::findAll();
        include Router::getSourcePath() . "views/admin/manage_company.inc.php";
    }
    //หน้า export ไฟล์ตัวอย่าง excel บริษัทลูกค้า
    private function export_excel_test_company($params = null)
    {
        $exportExcel = new Company();
        $exportExcelCompany = Company::findAll();

        try {
            // ob_end_clean();

            // เรียนกใช้ PHPExcel
            $objPHPExcel = new PHPExcel();
            // กำหนดค่าต่างๆ ของเอกสาร excel
            $objPHPExcel->getProperties()->setCreator("bp.com")
                ->setLastModifiedBy("bp.com")
                ->setTitle("PHPExcel Test Document")
                ->setSubject("PHPExcel Test Document")
                ->setDescription("Test document for PHPExcel, generated using PHP classes.")
                ->setKeywords("office PHPExcel php")
                ->setCategory("Test result file");

            // กำหนดชื่อให้กับ worksheet ที่ใช้งาน
            $objPHPExcel->getActiveSheet()->setTitle('Report');

            // กำหนด worksheet ที่ต้องการให้เปิดมาแล้วแสดง ค่าจะเริ่มจาก 0 , 1 , 2 , ......
            $objPHPExcel->setActiveSheetIndex(0);

            // การจัดรูปแบบของ cell
            $objPHPExcel->getDefaultStyle()
                ->getAlignment()
                ->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP)
                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            //HORIZONTAL_CENTER //VERTICAL_CENTER

            // จัดความกว้างของคอลัมน์
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(20);


            // กำหนดหัวข้อให้กับแถวแรก
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1', 'ID_Company')
                ->setCellValue('B1', 'Name_Company')
                ->setCellValue('C1', 'Address_Company')
                ->setCellValue('D1', 'PROVINCE_ID')
                ->setCellValue('E1', 'AMPHUR_ID')
                ->setCellValue('F1', 'Tel_Company')
                ->setCellValue('G1', 'Email_Company')
                ->setCellValue('H1', 'Tax_Number_Company')
                ->setCellValue('I1', 'Credit_Limit_Company')
                ->setCellValue('J1', 'Credit_Term_Company')
                ->setCellValue('K1', 'Cluster_Shop')
                ->setCellValue('L1', 'Contact_Name_Company')
                ->setCellValue('M1', 'IS_Blacklist')
                ->setCellValue('N1', 'Cause_Blacklist');;


            $start_row = 2;
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A' . $start_row, "111")
                ->setCellValue('B' . $start_row, "FIRSTSTEP")
                ->setCellValue('C' . $start_row, "300/15 montisuriyawong")
                ->setCellValue('D' . $start_row, "1")
                ->setCellValue('E' . $start_row, " ")
                ->setCellValue('F' . $start_row, "1234567890")
                ->setCellValue('G' . $start_row, "test_@hotmail.com")
                ->setCellValue('H' . $start_row, "1234567891234")
                ->setCellValue('I' . $start_row, "50000 บาท")
                ->setCellValue('J' . $start_row, "30 วัน")
                ->setCellValue('K' . $start_row, "ภาคเอกชน")
                ->setCellValue('L' . $start_row, "คุณณัฐวัฒน์")
                ->setCellValue('M' . $start_row, "ใช่")
                ->setCellValue('N' . $start_row, "ค้างจ่าย 2 เดือน");

            $i = 0;

            $filename = 'Company-' . date("dmYHis") . '.xlsx'; //  กำหนดชือ่ไฟล์ นามสกุล xls หรือ xlsx

            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');  // Excel2007 (xlsx) หรือ Excel5 (xls)
            ob_clean();

            $objWriter->save('./uploads/' . $filename);

            //download
            header('Content-Type: application/octet-stream');
            header("Content-Transfer-Encoding: Binary");
            header("Content-disposition: attachment; filename=\"" . $filename . "\"");
            echo file_get_contents("./uploads/" . $filename);
            die;


            return json_encode(array('status' => true, "filename" => $filename));
            //ob_end_clean();

            // die($objWriter);
            //die;


        } catch (Exception $e) {
            // status that return to frontend
            $status = false;
            // error message handle
            $message = $e->getMessage();
        }


        return json_encode(array('status' => true));
    }
    //หน้าจัดการยอดขาย
    private function manage_sales($params = null)
    {
        session_start();
        $employee = $_SESSION["employee"];
        # retrieve data
        $sales = Sales::findAll();
        $employeeList = Employee::findAll();
        $companyList = Company::findAll();
        $file_log = Filelog::findByPage('manage_sales');

        include Router::getSourcePath() . "views/admin/manage_sales.inc.php";
    }
    //หน้า export ไฟล์ตัวอย่าง excel ยอดขาย
    private function export_excel_test_sales($params = null)
    {
        $exportExcel = new Sales();
        $exportExcelEmployee = Sales::findAll();

        try {
            // ob_end_clean();

            // เรียนกใช้ PHPExcel
            $objPHPExcel = new PHPExcel();
            // กำหนดค่าต่างๆ ของเอกสาร excel
            $objPHPExcel->getProperties()->setCreator("bp.com")
                ->setLastModifiedBy("bp.com")
                ->setTitle("PHPExcel Test Document")
                ->setSubject("PHPExcel Test Document")
                ->setDescription("Test document for PHPExcel, generated using PHP classes.")
                ->setKeywords("office PHPExcel php")
                ->setCategory("Test result file");

            // กำหนดชื่อให้กับ worksheet ที่ใช้งาน
            $objPHPExcel->getActiveSheet()->setTitle('Report');

            // กำหนด worksheet ที่ต้องการให้เปิดมาแล้วแสดง ค่าจะเริ่มจาก 0 , 1 , 2 , ......
            $objPHPExcel->setActiveSheetIndex(0);

            // การจัดรูปแบบของ cell
            $objPHPExcel->getDefaultStyle()
                ->getAlignment()
                ->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP)
                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            //HORIZONTAL_CENTER //VERTICAL_CENTER

            // จัดความกว้างของคอลัมน์
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);


            // กำหนดหัวข้อให้กับแถวแรก
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1', 'Date_Sales')
                ->setCellValue('B1', 'ID_Company')
                ->setCellValue('C1', 'ID_Employee')
                ->setCellValue('D1', 'Result_Sales');

            $start_row = 2;
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A' . $start_row, "12/05/2564")
                ->setCellValue('B' . $start_row, "2")
                ->setCellValue('C' . $start_row, "s009")
                ->setCellValue('D' . $start_row, "5000");


            $i = 0;

            $filename = 'Sales-' . date("dmYHis") . '.xlsx'; //  กำหนดชือ่ไฟล์ นามสกุล xls หรือ xlsx

            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');  // Excel2007 (xlsx) หรือ Excel5 (xls)
            ob_clean();

            $objWriter->save('./uploads/' . $filename);

            //download
            header('Content-Type: application/octet-stream');
            header("Content-Transfer-Encoding: Binary");
            header("Content-disposition: attachment; filename=\"" . $filename . "\"");
            echo file_get_contents("./uploads/" . $filename);
            die;


            return json_encode(array('status' => true, "filename" => $filename));
            //ob_end_clean();

            // die($objWriter);
            //die;


        } catch (Exception $e) {
            // status that return to frontend
            $status = false;
            // error message handle
            $message = $e->getMessage();
        }


        return json_encode(array('status' => true));
    }

//หน้าจัดการข่าวสาร
    private function manage_news($params = null) 
    {
        session_start();
        $employee = $_SESSION["employee"];

        # retrieve data       

        $message = Message::fetchAll();
    
        $file_log = Filelog::findByPage('manage_news');


       include Router::getSourcePath() . "views/admin/manage_news.inc.php";

    }
//หน้าจัดการรางวัล
    private function manage_award() 
    {
        session_start();
        $employee = $_SESSION["employee"];

        # retrieve data       
    
        $employeeList = Employee::findAll();
        $awardList = Award::fetchAll();


        include Router::getSourcePath() . "views/admin/manage_award.inc.php";
    }

    //หน้าจัดการสินค้าส่งเสริมการขาย
    private function manage_promotion($params = null)
    {
        session_start();
        $employee = $_SESSION["employee"];

        # retrieve data
        $promotionList = Promotion::findAll();

        include Router::getSourcePath() . "views/admin/manage_promotion.inc.php";
    }

}