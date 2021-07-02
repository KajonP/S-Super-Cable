<?php

class BorrowController
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
            case "borrow":
                session_start();
                $this->borrow();
                break;
            default:
                break;
        }
    }

    private function borrow()
    {
        //print_r($_SESSION);
        $employee = $_SESSION['employee'];
        $promotion = Promotion::listArray();
        //print_r($promotion);
        //exit;
        include Router::getSourcePath() . "views/sales/borrow.inc.php";
    }

    
    // ควรมีสำหรับ controller ทุกตัว
    private function index()
    {
        include Router::getSourcePath() . "views/login.inc.php";
    }

}