<?php

class ZoneController
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
            case "manage_zone" :
                $this->$action();
                break;
            case "create_zone" :
                $result = $this->$action($params["POST"]);
                echo $result;
                break;
            case "edit_zone" :
                $ID_Zone = isset($params["GET"]["ID_Zone"]) ? $params["GET"]["ID_Zone"] : "";
                $result = $this->$action($params["POST"], $ID_Zone);
                echo $result;
                break;
            case "delete_zone":
                $result = $this->$action($params["POST"]["ID_Zone"]);
                echo $result;
                break;
            case "findbyID_Zone":
                $ID_Zone = isset($params["POST"]["ID_Zone"]) ? $params["POST"]["ID_Zone"] : "";

                if (!empty($ID_Zone)) {
                    $result = $this->$action($ID_Zone);
                    echo $result;
                }
                break;
            default:
                break;
        }
    }
    private function create_zone($params)
    {
        # สร้างโซน
        $access_zone = new Zone();
        if(count($params['ID_Employee']) > 0){
            foreach($params['ID_Employee'] as $val){
                $data_arr = array(
                                'ID_Employee' => $val,
                                'AMPHUR_ID' => isset($params['AMPHUR_ID']) ? $params['AMPHUR_ID'] : NULL,
                                'PROVINCE_ID' => $params['PROVINCE_ID']
                            );
                $zone_result = $access_zone->create_zone($data_arr);
            }
        }
        return json_encode($zone_result);
    }
    private function edit_zone($params, $ID_Zone)
    {
        # อัปเดตโซน
        $am = isset($params['AMPHUR_ID']) ? $params['AMPHUR_ID'] : NULL;
        if($params['PROVINCE_ID']!='1'){
            $am = NULL;
        }
        $data_arr = array(
                        'ID_Employee' => $params['ID_Employee'][0],
                        'AMPHUR_ID' => $am,
                        'PROVINCE_ID' => $params['PROVINCE_ID']
                    );
        $access_zone = new Zone();
        $zone_result = $access_zone->edit_zone(
            $data_arr, $ID_Zone
        );
        echo json_encode($zone_result);

    }

    private function delete_zone($ID_Zone)
    {
        # ลบโซน
        $access_zone = new Zone();
        $access_zone = $access_zone->delete_zone(
            $ID_Zone
        );
        return json_encode($access_zone);
    }
    private function findbyID_Zone(string $ID_Zone)
    {
        $zone = Zone::findById($ID_Zone);//echo json_encode($sales);


        $data_sendback = array(
            "ID_Zone" => $zone->getID_Zone(),
            "ID_Employee" => $zone->getID_Employee(),
            //"ID_Company" => $zone->getID_Company(),
            "AMPHUR_ID" => $zone->getAMPHUR_ID(),
            "PROVINCE_ID" => $zone->getPROVINCE_ID(),

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
    //หน้าจัดการโซน
    private function manage_zone($params = null)
    {
        session_start();
        $employee = $_SESSION["employee"];
        # retrieve data
        $zoneList = Zone::findAll();
        $employeeList = Employee::findAll();
        $companyList = Company::findAll();
        $amphurList = Amphur::findAll();
        $provinceList = Province::findAll();
        include Router::getSourcePath() . "views/admin/manage_zone.inc.php";
    }
}