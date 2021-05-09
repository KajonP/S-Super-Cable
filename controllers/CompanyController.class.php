<?php

# excel library
include Router::getSourcePath() . 'classes/Excel.class.php';


class CompanyController
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
            case "import_excel":
                $FILES = isset($params["FILES"]["file"]) ? $params["FILES"]["file"] : "";
                $result = $this->$action($params["POST"], $FILES);
                echo $result;
                break;
            case "findbyID":
                $ID_Company = isset($params["POST"]["ID_Company"]) ? $params["POST"]["ID_Company"] : "";

                if (!empty($ID_Company)) {
                    $result = $this->$action($ID_Company);
                    echo $result;
                }
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
            //$h = $worksheet->getRowIterator();
            $highestColumn = $worksheet->getHighestColumn();
            //  echo $highestRow;exit();
            // row = 2 คือ row แรก ไม่รวม header
            //$row = 2;
            // foreach ($h as $rows)
            for ($row = 2; $row <= $highestRow; $row++) {
                if ($worksheet->getCellByColumnAndRow(0, $row)->getValue() != '') {
                    $ID_Company = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                    $Name_Company = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                    $Address_Company = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                    $Tel_Company = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                    $Email_Company = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                    $Tax_Number_Company = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
                    $Credit_Limit_Company = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
                    $Credit_Term_Company = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
                    $Cluster_Shop = $worksheet->getCellByColumnAndRow(8, $row)->getValue();
                    $Contact_Name_Company = $worksheet->getCellByColumnAndRow(9, $row)->getValue();
                    $IS_Blacklist = $worksheet->getCellByColumnAndRow(10, $row)->getValue();
                    $Cause_Blacklist = $worksheet->getCellByColumnAndRow(11, $row)->getValue();

                    $push_array = array("ID_Company" => $ID_Company,
                        "Name_Company" => $Name_Company,
                        "Address_Company" => $Address_Company,
                        "Tel_Company" => $Tel_Company,
                        "Email_Company" => $Email_Company,
                        "Tax_Number_Company" => $Tax_Number_Company,
                        "Credit_Limit_Company" => $Credit_Limit_Company,
                        "Credit_Term_Company" => $Credit_Term_Company,
                        "Cluster_Shop" => $Cluster_Shop,
                        "Contact_Name_Company" => $Contact_Name_Company,
                        "IS_Blacklist" => $IS_Blacklist,
                        "Cause_Blacklist" => $Cause_Blacklist
                    );
                    array_push($params, $push_array);
                }

            }
        }
        // # create company ใหม่
        $company_ = new Company();
        $result = $company_->create_company_at_once($params);
        return json_encode($result);
    }

    private function error_handle(string $message)
    {
        $this->index($message);
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

    private function findbyID(string $ID_Company)
    {
        $company = Company::findById($ID_Company);//echo json_encode($employee);

        $data_sendback = array(
            "ID_Company" => $company->getID_Company(),
            "Name_Company" => $company->getName_Company(),
            "Address_Company" => $company->getAddress_Company(),
            "Tel_Company" => $company->getTel_Company(),
            "Email_Company" => $company->getEmail_Company(),
            "Tax_Number_Company" => $company->getTax_Number_Company(),
            "Credit_Limit_Company" => $company->getCredit_Limit_Company(),
            "Credit_Term_Company" => $company->getCredit_Term_Company(),
            "Cluster_Shop" => $company->getCluster_Shop(),
            "Contact_Name_Company" => $company->getContact_Name_Company(),
            "IS_Blacklist" => $company->getIS_Blacklist(),
            "Cause_Blacklist" => $company->getCause_Blacklist()
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

    //หน้าจัดการบริษัทลูกค้า
    private function manage_company($params = null)
    {
        session_start();
        $employee = $_SESSION["employee"];
        # retrieve data
        $company = Company::findAll();

        include Router::getSourcePath() . "views/admin/manage_company.inc.php";
    }

}