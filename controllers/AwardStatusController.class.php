<?php

class AwardStatusController
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
            case "show_award":
                session_start();
                $employee = $_SESSION["employee"];

                if ($employee->getUser_Status_Employee() == "Admin") {
                    include Router::getSourcePath() . "views/index_admin.inc.php";
                } else if ($employee->getUser_Status_Employee() == "Sales") {
                    # retrieve data
                    $awardList = Award::fetchAllwithInner($employee->getID_Employee());
                    $countAllAward = Award::fetchCountAll($employee->getID_Employee());
                    include Router::getSourcePath() . "views/sales/index_award.inc.php";
                } else if ($employee->getUser_Status_Employee() == "User") {
                    # retrieve data
                    $awardList = Award::fetchAllwithInner($employee->getID_Employee());
                    $countAllAward = Award::fetchCountAll($employee->getID_Employee());
                    include Router::getSourcePath() . "views/sales/index_award.inc.php";
                }
                break;
            case "update_status_award":
                session_start();
                $employee = $_SESSION['employee'];
                $ID_Award = isset($params["GET"]["ID_Award"]) ? $params["GET"]["ID_Award"] : "";
                if ($employee->getUser_Status_Employee() == "Admin") {
                    include Router::getSourcePath() . "views/index_admin.inc.php";
                } else if ($employee->getUser_Status_Employee() == "Sales") {
                    # retrieve data
                    $award = Award::update_award_status($employee->getID_Employee(), $ID_Award);
                    $awardList = Award::fetchAllwithInner($employee->getID_Employee());
                    include Router::getSourcePath() . "views/sales/redirect_index_award.inc.php";
                } else if ($employee->getUser_Status_Employee() == "User") {
                    # retrieve data
                    $award = Award::update_award_status($employee->getID_Employee(), $ID_Award);
                    $awardList = Award::fetchAllwithInner($employee->getID_Employee());
                    include Router::getSourcePath() . "views/sales/redirect_index_award.inc.php";

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