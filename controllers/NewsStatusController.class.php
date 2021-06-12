<?php

class NewsStatusController
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
            case "show_news":
                session_start();
                $employee = $_SESSION['employee'];

                if ($employee->getUser_Status_Employee() == "Admin") {
                    include Router::getSourcePath() . "views/index_admin.inc.php";
                } else if ($employee->getUser_Status_Employee() == "Sales") {
                    # retrieve data
                    $message = Message::fetchAllwithInner($employee->getID_Employee());
                    $countAll = Message::fetchCountAll($employee->getID_Employee());
                    include Router::getSourcePath() . "views/sales/index_news.inc.php";
                } else if ($employee->getUser_Status_Employee() == "User") {
                    # retrieve data
                    $message = Message::fetchAllwithInner($employee->getID_Employee());
                    $countAll = Message::fetchCountAll($employee->getID_Employee());
                    include Router::getSourcePath() . "views/sales/index_news.inc.php";
                }
                break;
            case "update_status_news":
                session_start();
                $employee = $_SESSION['employee'];
                $ID_Message = isset($params["GET"]["ID_Message"]) ? $params["GET"]["ID_Message"] : "";
                if ($employee->getUser_Status_Employee() == "Admin") {
                    include Router::getSourcePath() . "views/index_admin.inc.php";
                } else if ($employee->getUser_Status_Employee() == "Sales") {
                    # retrieve data
                    $message = Message::update_news_status($employee->getID_Employee(), $ID_Message);
                    include Router::getSourcePath() . "views/sales/redirect_index_news.inc.php";
                } else if ($employee->getUser_Status_Employee() == "User") {
                    # retrieve data
                    $message = Message::update_news_status($employee->getID_Employee(), $ID_Message);
                    include Router::getSourcePath() . "views/sales/redirect_index_news.inc.php";
                }
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
    private function index($message)
    {
        include Router::getSourcePath() . "views/error_handle.inc.php";
    }
}