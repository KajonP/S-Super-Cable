<?php

class NewsPricesController
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
                session_start();
                $employee = $_SESSION['employee'];

                if ($employee->getUser_Status_Employee() == "Admin") {
                    # find all employee
                    $user_count = count(Employee::findAll());
                    include Router::getSourcePath() . "views/index_admin.inc.php";
                } else if ($employee->getUser_Status_Employee() == "Sales") {
					# retrieve data       
					$message = Message::fetchAllwithInner($employee->getID_Employee());
					$awardList = Award::fetchAllwithInner($employee->getID_Employee());
					$countAll = Message::fetchCountAll();
					$countAllAward = Award::fetchCountAll();

                    include Router::getSourcePath() . "views/index_news.inc.php";
                } else if ($employee->getUser_Status_Employee() == "User") {

                    include Router::getSourcePath() . "views/index_user.inc.php";
                }
                break;
			case "index2":
                session_start();
                $employee = $_SESSION['employee'];
				$ID_Message = isset($params["GET"]["ID_Message"]) ? $params["GET"]["ID_Message"] : "";
                if ($employee->getUser_Status_Employee() == "Admin") {
                    # find all employee
                    $user_count = count(Employee::findAll());
                    include Router::getSourcePath() . "views/index_admin.inc.php";
                } else if ($employee->getUser_Status_Employee() == "Sales") {
					# retrieve data       
					$message = Message::update_news_status($employee->getID_Employee(), $ID_Message);
					#$awardList = Award::fetchAll();
					$awardList = Award::fetchAllwithInner($employee->getID_Employee());
                    include Router::getSourcePath() . "views/redirect_index_news.inc.php";
                } else if ($employee->getUser_Status_Employee() == "User") {

                    include Router::getSourcePath() . "views/index_user.inc.php";
                }
                break;
			case "index3":
                session_start();
                $employee = $_SESSION['employee'];
				$ID_Award = isset($params["GET"]["ID_Award"]) ? $params["GET"]["ID_Award"] : "";
                if ($employee->getUser_Status_Employee() == "Admin") {
                    # find all employee
                    $user_count = count(Employee::findAll());
                    include Router::getSourcePath() . "views/index_admin.inc.php";
                } else if ($employee->getUser_Status_Employee() == "Sales") {
					# retrieve data       
					$award = Award::update_award_status($employee->getID_Employee(), $ID_Award);
					$awardList = Award::fetchAllwithInner($employee->getID_Employee());
					#$awardList = Award::fetchAll();
                    include Router::getSourcePath() . "views/redirect_index_news.inc.php";
                } else if ($employee->getUser_Status_Employee() == "User") {

                    include Router::getSourcePath() . "views/index_user.inc.php";
                }
                break;
			case "prices":
                session_start();
                $employee = $_SESSION['employee'];

                if ($employee->getUser_Status_Employee() == "Admin") {
                    # find all employee
                    $user_count = count(Employee::findAll());
                    include Router::getSourcePath() . "views/index_admin.inc.php";
                } else if ($employee->getUser_Status_Employee() == "Sales") {

                    include Router::getSourcePath() . "views/index_prices.inc.php";
                } else if ($employee->getUser_Status_Employee() == "User") {

                    include Router::getSourcePath() . "views/index_user.inc.php";
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