<?php

class SalesStatisticsController
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
            case "manage_SalesStatistics" :
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
    //หน้าจัดการSalesStatistics
    private function manage_SalesStatistics($params = null)
    {
        session_start();
        $employee = $_SESSION["employee"];
        # retrieve data
        $zoneList = Zone::findAll();
        $employeeList = Employee::findAll();
        $companyList = Company::findAll();
        $amphurList = Amphur::findAll();
        $provinceList = Province::findAll();
        include Router::getSourcePath() . "views/admin/sales_statistics.inc.php";
    }
}