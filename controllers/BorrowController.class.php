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
             case "borrow_insert":
                session_start();
                $this->borrowInsert();
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
        $borrow = BorrowOrReturn::find([]);
        //print_r($borrow);
        //exit;
        //print_r($_SESSION['employee']->getID_Employee());
        //$b = BorrowOrReturn::findAll();
        include Router::getSourcePath() . "views/sales/borrow.inc.php";
    }

    private function borrowInsert(){
        $access = new BorrowOrReturn();
        $access_params = array(
            'ID_Promotion' => $_POST['ID_Promotion'],
            'Amount_BorrowOrReturn' => $_POST['Amount_BorrowOrReturn'],
            'Date_BorrowOrReturn' => date('Y-m-d'),
            'Detail_BorrowOrReturn' => $_POST['Detail_BorrowOrReturn'],
            'ID_Employee' => $_SESSION['employee']->getID_Employee(),
            'Type_BorrowOrReturn' => '1',
            'Approve_BorrowOrReturn' => '0'
        );

        $result = $access->create($access_params);
        header('Content-type: application/json');
        echo json_encode(["status" => true]);
    }
    
    // ควรมีสำหรับ controller ทุกตัว
    private function index()
    {
        include Router::getSourcePath() . "views/login.inc.php";
    }

}