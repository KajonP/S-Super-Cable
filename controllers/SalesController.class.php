<?php
# excel library
include Router::getSourcePath() . 'classes/Excel.class.php';

class SalesController {

    /**
     * handleRequest จะทำการตรวจสอบ action และพารามิเตอร์ที่ส่งเข้ามาจาก Router
     * แล้วทำการเรียกใช้เมธอดที่เหมาะสมเพื่อประมวลผลแล้วส่งผลลัพธ์กลับ
     *
     * @param string $action ชื่อ action ที่ผู้ใช้ต้องการทำ
     * @param array $params พารามิเตอร์ที่ใช้เพื่อในการทำ action หนึ่งๆ
     */
    public function handleRequest(string $action="index", array $params) {
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
                $result = $this->$action($params["POST"] , $ID_Excel);
                echo $result;
                break;
            case "delete_sales":
                $result = $this->$action($params["POST"]["ID_Excel"]);
                echo $result;
                break;
            case "import_excel":
                $FILES = isset($params["FILES"]["file"]) ? $params["FILES"]["file"] : "";
                $result = $this->$action($params["POST"] , $FILES );
                echo $result;
                break;
            case "findbyID":
                $ID_Excel = isset($params["POST"]["ID_Excel"]) ? $params["POST"]["ID_Excel"] : "";

                if(!empty($ID_Excel)){
                    $result = $this->$action($ID_Excel);
                    echo $result;
                }
                break;
            default:
                break;
        }
    }
    private function import_excel(array $params , array $FILES){
        $excel = new Excel();
        $path = $FILES["tmp_name"];
        $object = PHPExcel_IOFactory::load($path);
        $params = array();
        foreach($object->getWorksheetIterator() as $worksheet)
        {
            $highestRow = $worksheet->getHighestRow();
            $highestColumn = $worksheet->getHighestColumn();
            //  echo $highestRow;exit();
            // row = 2 คือ row แรก ไม่รวม header
            for ($row = 2; $row <= $highestRow; $row++) {
                if ($worksheet->getCellByColumnAndRow(0, $row)->getValue() != '') {
                    //$ID_Excel = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                    $Date_Sales = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                    $ID_Company = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                    $ID_Employee = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                    $Result_Sales = $worksheet->getCellByColumnAndRow(3, $row)->getValue();


                    $strStartDate = "1900-01-01";
                    $date = $Date_Sales;
                    $strto_dayte =  strtotime("+" . $date . "days", strtotime($strStartDate));

                    $push_array = array(//"ID_Excel" => $ID_Excel,
                        "Date_Sales" =>date("Y-m-d", $strto_dayte),
                        "ID_Company" => $ID_Company,
                        "ID_Employee" => $ID_Employee,
                        "Result_Sales" => $Result_Sales
                    );
                    array_push($params, $push_array);
                }

            }
        }
        // # create sales ใหม่
        $sales_ = new Sales();
        $result = $sales_->create_sales_at_once($params);
        return json_encode($result);
    }
    private function error_handle(string $message) {
        $this->index($message);
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

    private function findbyID(string $ID_Excel)
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

    // ควรมีสำหรับ controller ทุกตัว
    private function index($message = null)
    {
        session_start();
        $employee = $_SESSION["employee"];
        include Router::getSourcePath() . "views/index_admin.inc.php";
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

        include Router::getSourcePath() . "views/admin/manage_sales.inc.php";
    }

}