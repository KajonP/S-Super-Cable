<?php

# excel library
include Router::getSourcePath() . 'classes/Excel.class.php';


class ResultSalesController
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
            default:
                break;
        }
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
                , "Name_Company" => array("name" => "ชื่อบริษัทลูกค้า", "status" => false, "error" => "ไม่พบข้อมูลคอลัมน์ ชื่อบริษัทลูกค้า")
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
                            $com_data = Company::findName($getCellArray["data"][1]);
                            if(count($com_data)=='0'){
                                $message = "มีบางอย่างผิดพลาด , ไม่พบข้อมูลบริษัท";
                                return json_encode(array("status" => false, "message" => $message));
                            }
                            //print_r($com_data);
                            $com_id = $com_data[0]->getID_Company();
                            //echo  $com_id;
                            $push_array = array(//"ID_Excel" => $ID_Excel,
                                "Date_Sales" => $date,
                                "ID_Company" => $com_id,
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
    private function error_handle(string $message)
    {
        $this->index($message);
    }

    // ควรมีสำหรับ controller ทุกตัว
    private function index($message = null)
    {
        include Router::getSourcePath() . "views/login.inc.php";
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


}