<?php

# excel library
include Router::getSourcePath() . 'classes/Excel.class.php';


class GoodsController
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
            case "manage_goods" :
                $this->$action();
                break;
            case "create_goods" :
                $result = $this->$action($params["POST"]);
                echo $result;
                break;
            case "edit_goods" :
                $ID_Goods = isset($params["GET"]["ID_Goods"]) ? $params["GET"]["ID_Goods"] : "";
                $result = $this->$action($params["POST"], $ID_Goods);
                echo $result;
                break;
            case "delete_goods":
                $result = $this->$action($params["POST"]["ID_Goods"]);
                echo $result;
                break;
            case "import_excel_goods":
                $FILES = isset($params["FILES"]["file"]) ? $params["FILES"]["file"] : "";
                $FILE_IMG = isset($params["FILES"]["examfile"]) ? $params["FILES"]["examfile"] : "";
                $result = $this->$action($params["POST"], $FILES, $FILE_IMG);
                echo $result;
                break;
            case "findbyID_Goods":
                $ID_Goods = isset($params["POST"]["ID_Goods"]) ? $params["POST"]["ID_Goods"] : "";
                //print_r($ID_Goods);exit();
                if (!empty($ID_Goods)) {
                    $result = $this->$action($ID_Goods);
                    echo $result;
                }
                break;
            case "export_excel_test_goods":
                $result = $this->$action($params["POST"]);
                echo $result;
                break;
            default:
                break;
        }
    }

    private function import_excel_goods(array $params, array $FILES, array $FILE_IMG)
    {
        $excel = new Excel();
        #UPLOAD IMAGE
        if (!empty($FILE_IMG) && !empty($FILE_IMG['name'])) {
            # update new pic
            $target_file_img = Router::getSourcePath() . "images/" . $FILE_IMG['name'];

            if (!empty($FILE_IMG) && isset($FILE_IMG['name'])) {
                if (!empty($FILE_IMG['name'])) {
                    move_uploaded_file($FILE_IMG["tmp_name"], $target_file_img);

                    $goods_ = new Goods();
                    $goods_->file_log($FILE_IMG['name'], 4);
                }
            }

        }
        #UPLOAD EXCEL

        if (!empty($FILES) && !empty($FILES['name'])) {
            $path = $FILES["tmp_name"];
            $object = PHPExcel_IOFactory::load($path);
            $params = array();

            //case: การอัพโหลดไฟล์ excel ถ้าลืมใส่ column ไหนให้บอกผิด row ไหน
            $EXCEL_HeaderCol = array("Name_Goods" => array("name" => "ชื่อสินค้า", "status" => false, "error" => "ไม่พบข้อมูลคอลัมน์ ชื่อสินค้า")
            , "Detail_Goods" => array("name" => "รายละเอียดสินค้า", "status" => false, "error" => "ไม่พบข้อมูลคอลัมน์ รายละเอียดสินค้า")
            , "Price_Goods" => array("name" => "ราคาสินค้า", "status" => false, "error" => "ไม่พบข้อมูลคอลัมน์ Price_Goods")
            );
            $count = 0;
            foreach ($object->getWorksheetIterator() as $worksheet) {
                $highestRow = $worksheet->getHighestRow();
                $highestColumn = $worksheet->getHighestColumn();
                //  echo $highestRow;exit();
                // row = 2 คือ row แรก ไม่รวม header
                #เช็คหัวตารางชื่อตรงกันไหมใน array ที่ hardcode ไว้
                if ($count != 1) {
                    for ($col_ = 0; $col_ < 3; $col_++) {
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
                        $getCellArray = $this->checkemptycell_goods($worksheet, $row);
                        if ($getCellArray['status'] == false) {
                            $c = array_values($EXCEL_HeaderCol);
                            $message = "มีบางอย่างผิดพลาด , กรุณาตรวจสอบข้อมูลไม่พบข้อมูลในแถวที่{$row}(รวมหัวตาราง) ในคอลัมน์คือ " . $c[$getCellArray["column"]]['name'] . '';
                            return json_encode(array("status" => false, "message" => $message));
                        }


                        $push_array = array("Name_Goods" => $getCellArray["data"][0],
                            "Detail_Goods" => $getCellArray["data"][1],
                            "Price_Goods" => $getCellArray["data"][2]
                        );
                        array_push($params, $push_array);
                    } else {


                    }
                }
            }
            // # create goods ใหม่
            $goods_ = new Goods();
            $result = $goods_->create_goods_at_once($params);
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

    private function checkemptycell_goods($worksheet, $row)
    {
        $push_array = array();
        for ($i = 0; $i < 3; $i++) {
            if (empty($worksheet->getCellByColumnAndRow($i, $row)->getValue())) {
                return array("status" => false, "column" => $i, "row" => $row);
            } else {
                $push_array[$i] = $worksheet->getCellByColumnAndRow($i, $row)->getValue();
            }
        }

        return array("status" => true, "data" => $push_array);

    }

    private function create_goods($params)
    {
        # สร้างสินค้า
        $access_goods = new Goods();
        $goods_result = $access_goods->create_goods(
            $params
        );
        return json_encode($goods_result);
    }

    private function edit_goods($params, $ID_Goods)
    {
        # อัปเดตสินค้า
        $access_goods = new Goods();
        $goods_result = $access_goods->edit_goods(
            $params, $ID_Goods
        );
        echo json_encode($goods_result);

    }

    private function delete_goods($ID_Goods)
    {
        # ลบสินค้า
        $access_goods = new Goods();
        $goods_result = $access_goods->delete_goods(
            $ID_Goods
        );
        return json_encode($goods_result);
    }

    private function findbyID_Goods(string $ID_Goods)
    {
        $goods = Goods::findById($ID_Goods);//echo json_encode($employee);

        $data_sendback = array(
            "ID_Goods" => $goods->getID_Goods(),
            "Name_Goods" => $goods->getName_Goods(),
            "Detail_Goods" => $goods->getDetail_Goods(),
            "Price_Goods" => $goods->getPrice_Goods(),

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
        session_start();
        $employee = $_SESSION["employee"];
        include Router::getSourcePath() . "views/index_admin.inc.php";

    }

    //หน้าจัดการสินค้า
    private function manage_goods($params = null)
    {
        session_start();
        $employee = $_SESSION["employee"];
        # retrieve data
        $goods = Goods::findAll();
        $file_log = Filelog::findByPage('manage_goods');

        include Router::getSourcePath() . "views/admin/manage_goods.inc.php";
    }

    //หน้า export ไฟล์ตัวอย่าง excel สินค้า
    private function export_excel_test_goods($params = null)
    {
        $exportExcel = new Goods();
        $exportExcelGoods = Goods::findAll();

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
                ->setCellValue('A1', 'Name_Goods')
                ->setCellValue('B1', 'Detail_Goods')
                ->setCellValue('C1', 'Price_Goods');

            $start_row = 2;
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A' . $start_row, "สายไฟ")
                ->setCellValue('B' . $start_row, "-")
                ->setCellValue('C' . $start_row, "2000");

            $i = 0;

            $filename = 'Goods-' . date("dmYHis") . '.xlsx'; //  กำหนดชือ่ไฟล์ นามสกุล xls หรือ xlsx

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