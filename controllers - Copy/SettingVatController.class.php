<?php

class SettingVatController
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
            case "manage_setting_vat" :
                $this->$action();
                break;
            case "edit_setting_vat" :
                $ID_Setting_Vat = isset($params["GET"]["ID_Setting_Vat"]) ? $params["GET"]["ID_Setting_Vat"] : "";
                $result = $this->$action($params["POST"], $ID_Setting_Vat);
                echo $result;
                break;
            case "findbyID":
                $ID_Setting_Vat = isset($params["POST"]["ID_Setting_Vat"]) ? $params["POST"]["ID_Setting_Vat"] : "";

                if (!empty($ID_Setting_Vat)) {
                    $result = $this->$action($ID_Setting_Vat);
                    echo $result;
                }
                break;
            default:
                break;
        }
    }
    private function edit_setting_vat($params, $ID_Setting_Vat)
    {
        # อัปเดตตั้งค่า vat
        $access_setting_vat = new Setting_Vat();
        $setting_vat_result = $access_setting_vat->edit_setting_vat(
            $params, $ID_Setting_Vat
        );
        echo json_encode($setting_vat_result);

    }
    private function findbyID(int $ID_Setting_Vat)
    {
        $setting_vat = Setting_Vat::findById($ID_Setting_Vat);//echo json_encode($sales);


        $data_sendback = array(
            "ID_Setting_Vat" => $setting_vat->getID_Setting_Vat(),
            "Percent_Vat" => $setting_vat->getPercent_Vat(),
            "Date_Setting" => $setting_vat->getDate_Setting(),

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

    } //หน้าตั้งค่า vat
    private function manage_setting_vat($params = null)
    {
        session_start();
        $employee = $_SESSION["employee"];

        # retrieve data
        $setting_vat= Setting_Vat::findAll();

        include Router::getSourcePath() . "views/admin/manage_setting_vat.inc.php";
    }

}