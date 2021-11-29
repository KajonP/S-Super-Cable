<?php

# excel library
include Router::getSourcePath() . 'classes/Excel.class.php';


class CompanyAddressController
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
            case "edit_company" :
                $ID_Company = isset($params["GET"]["ID_Company"]) ? $params["GET"]["ID_Company"] : "";
                $result = $this->$action($params["POST"], $ID_Company);
                echo $result;
                break;
            case "delete_company":
                $result = $this->$action($params["POST"]["ID_Company"]);
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

        }
    }

    private function getAmphur($PROVINCE_ID){
        $access_company = new Company();
        $amphur_result = $access_company->getAmphur(
            $PROVINCE_ID
        );

        echo json_encode($amphur_result);

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
            "Cluster_Shop_ID" => $company->getCluster_Shop_ID(),
            "Contact_Name_Company" => $company->getContact_Name_Company(),
            "IS_Blacklist" => $company->getIS_Blacklist(),
            "Cause_Blacklist" => $company->getCause_Blacklist(),
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
    //หน้าจัดการบริษัทลูกค้า
    private function manage_company($params = null)
    {
        session_start();
        $employee = $_SESSION["employee"];
        # retrieve data
        $company = Company::findAllNoAddress();
        $file_log = Filelog::findByPage('manage_company');
        $provinceList = Province::findAll();
        $amphurList = Amphur::findAll();
        $cluster_shopList = Cluster_Shop::findAll();
        include Router::getSourcePath() . "views/admin/manage_company_address.inc.php";
    }
    private function getEmp($province,$amphur)
    {
        $sql = "SELECT employee.* FROM zone LEFT JOIN employee ON employee.ID_Employee = zone.ID_Employee WHERE zone.PROVINCE_ID='".$province."'";
        if($amphur!='' and $amphur!='-'){
            $sql .= ' AND zone.AMPHUR_ID="'.$amphur.'"';
        }

        $con = Db::getInstance();
        $stmt = $con->prepare($sql);
        //$stmt->setFetchMode(PDO::FETCH_COLUMN);
        $stmt->execute();
        $dataList = array();
        $txt = '';
        $i = 0;
        while ($prod = $stmt->fetch()) {
            if($i>'0'){
                $txt .= ',';
            }
            $txt .= $prod['Name_Employee'].' '.$prod['Surname_Employee'];
            $i++;
        }
        return $txt;
    }

}