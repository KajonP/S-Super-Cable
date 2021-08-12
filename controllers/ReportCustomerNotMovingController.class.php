<?php

class ReportCustomerNotMovingController
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
            case "customer_not_moving":
                session_start();
                $this->customer_not_moving();
                break;
            case "customer_not_moving_print":
                session_start();
                $this->customer_not_moving_print();
                break;
            default:
                break;
        }
    }

    private function customer_not_moving()
    {
        //print_r($_SESSION);
        $employee = $_SESSION['employee'];
        $date_start = isset($_GET['date_start']) ? $_GET['date_start'] : date('Y-m-d');
        $date_end =  isset($_GET['date_end']) ? $_GET['date_end'] : date('Y-m-d');
        $company = Invoice::customerNotMovingReport($date_start,$date_end);
        //print_r($company);
        include Router::getSourcePath() . "views/admin/report_customer_not_moving.inc.php";
    }


    private function customer_not_moving_print()
    {
        $employee = $_SESSION['employee'];
        $date_start = isset($_GET['date_start']) ? $_GET['date_start'] : date('Y-m-d');
        $date_end =  isset($_GET['date_end']) ? $_GET['date_end'] : date('Y-m-d');
        $company = Invoice::customerNotMovingReport($date_start,$date_end);
        //print_r($company);
        include "report-customer-not-moving.php";
    }

    
    // ควรมีสำหรับ controller ทุกตัว
    private function index()
    {
        include Router::getSourcePath() . "views/login.inc.php";
    }

}