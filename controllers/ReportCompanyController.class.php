<?php

class ReportCompanyController
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
            case "company" :
                $this->$action();
                break;
            case "getAjax" :
                $this->$action();
                break;
            default:
                break;
        }
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
    private function company($params = null)
    {
        session_start();
        $employee = $_SESSION["employee"];
        # retrieve data
        //$company = Company::findAll();
        $com_name = !empty($_POST['com_name']) ? $_POST['com_name'] : '';
        $company = [];
        //if($com_name!=''){
            //$company = Company::findSearch($com_name);
            $company = Company::findAll();
        //}
        $file_log = Filelog::findByPage('manage_company');
        $provinceList = Province::findAll();
        $amphurList = Amphur::findAll();
        $cluster_shopList = Cluster_Shop::findAll();
        include Router::getSourcePath() . "views/admin/report_company.inc.php";
    }

    private function getAjax()
    {
        session_start();
        $employee = $_SESSION["employee"];
        # retrieve data
        //$company = Company::findAll();
        $com_name = !empty($_POST['com_name']) ? $_POST['com_name'] : '';
        $company = [];
        $company = Company::findSearch($_POST['keyword']);
        $file_log = Filelog::findByPage('manage_company');
        $provinceList = Province::findAll();
        $amphurList = Amphur::findAll();
        $cluster_shopList = Cluster_Shop::findAll();
        $html = '';
        if(count($company)>0){
            foreach($company as $val){
                $html .= '<tr>
                            <td>'.$val->getName_Company().'</td>
                            <td>'.$this->getEmp($val->getPROVINCE_ID(),$val->getAMPHUR_ID()).'</td>
                            <td>
                                <a href="#" onclick="companymanageShow(\'view\',\''.$val->getID_Company().'\')">
                                <button type="button" class="btn btn-round btn-info" style=" font-size: 13px; padding: 0 15px; margin-bottom: inherit;width:96px !important;">
                                    <i class="fa fa-eye"></i>เพิ่มเติม
                                </button>
                                </a>
                            </td>
                        </tr>';
            }
        }
        echo $html;
    }

    private function getEmp($province, $amphur)
    {
        $sql = "SELECT employee.* FROM zone LEFT JOIN employee ON employee.ID_Employee = zone.ID_Employee WHERE zone.PROVINCE_ID='" . $province . "'";
        if ($amphur != '') {
            $sql .= ' AND zone.AMPHUR_ID="' . $amphur . '"';
        }
        $con = Db::getInstance();
        $stmt = $con->prepare($sql);
        //$stmt->setFetchMode(PDO::FETCH_COLUMN);
        $stmt->execute();
        $dataList = array();
        $txt = '';
        $i = 0;
        while ($prod = $stmt->fetch()) {
            if ($i > '0') {
                $txt .= ',';
            }
            $txt .= $prod['Name_Employee'] . ' ' . $prod['Surname_Employee'];
            $i++;
        }
        return $txt;
    }
}