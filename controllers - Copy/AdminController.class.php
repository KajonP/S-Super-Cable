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
            case "export_excel_test_company":
                $result = $this->$action($params["POST"]);
                echo $result;
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
    // ควรมีสำหรับ controller ทุกตัว
    private function index($message = null)
    {
        include Router::getSourcePath() . "views/login.inc.php";
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
}