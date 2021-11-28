<?php

class ReportController
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
            case "borrow":
                session_start();
                $this->borrow();
                break;
            case "borrow_print":
                session_start();
                $this->borrow_print();
                break;
            case "borrow_excel":
                session_start();
                $this->borrow_excel();
                break;
            default:
                break;
        }
    }

    private function borrow()
    {
        //print_r($_SESSION);
        $employee = $_SESSION['employee'];
        $date_start = isset($_GET['date_start']) ? $_GET['date_start'] : date('Y-m-d');
        $date_end =  isset($_GET['date_end']) ? $_GET['date_end'] : date('Y-m-d');
        $promotion = Promotion::listArray();
        $pro_name = [];
        $borrow = [];
        $borrow_return = [];
        if(count($promotion)>0){
            foreach($promotion as $val){
                $pro_name[] = $val->getName_Promotion();
                $pro_id = $val->getID_Promotion();
                $qty = BorrowOrReturn::report(['ID_Promotion'=> $pro_id , 'date_start' => $date_start , 'date_end' => $date_end]);
                $borrow[] = (int) $qty['borrow'];
                $borrow_return[] = (int) $qty['borrow_return'];
            }
        }
        $promotion_array = json_encode($pro_name);
        $borrow_array = json_encode($borrow);
        $borrow_return_array = json_encode($borrow_return);
        include Router::getSourcePath() . "views/admin/report_borrow.inc.php";
    }


    private function borrow_print()
    {
        //print_r($_SESSION);
        $employee = $_SESSION['employee'];
        $date_start = isset($_GET['date_start']) ? $_GET['date_start'] : date('Y-m-d');
        $date_end =  isset($_GET['date_end']) ? $_GET['date_end'] : date('Y-m-d');
        $promotion = Promotion::listArray();
        $emp = Employee::findAll();
        $pro_name = [];
        $borrow = [];
        $borrow_return = [];
        if(count($promotion)>0){
            foreach($promotion as $val){
                $pro_id = $val->getID_Promotion();
                $pro_name[] = ['name' => $val->getName_Promotion() , 'id' => $pro_id];
                if(count($emp)>0){
                    foreach($emp as $emp_val){
                        $empId = $emp_val->getID_Employee();
                        $qty = BorrowOrReturn::report([
                            'ID_Promotion'=> $pro_id , 
                            'date_start' => $date_start , 
                            'date_end' => $date_end,
                            'ID_Employee' => $empId
                        ]);
                        $borrow = (int) $qty['borrow'];
                        $borrow_return = (int) $qty['borrow_return'];
                        $report[$empId][$pro_id] = ['emp_name' => '' ,'borrow' => $borrow ];

                    }
                }
            }
        }
        $promotion_array = json_encode($pro_name);
        $borrow_array = json_encode($borrow);
        $borrow_return_array = json_encode($borrow_return);
        //include Router::getSourcePath() . "views/admin/report_borrow.inc.php";
        include "report_borroworreturn.php";
    }


      private function borrow_excel()
    {
        //print_r($_SESSION);
        $employee = $_SESSION['employee'];
        $date_start = isset($_GET['date_start']) ? $_GET['date_start'] : date('Y-m-d');
        $date_end =  isset($_GET['date_end']) ? $_GET['date_end'] : date('Y-m-d');
        $promotion = Promotion::listArray();
        $emp = Employee::findAll();
        $pro_name = [];
        $borrow = [];
        $borrow_return = [];
        if(count($promotion)>0){
            foreach($promotion as $val){
                $pro_id = $val->getID_Promotion();
                $pro_name[] = ['name' => $val->getName_Promotion() , 'id' => $pro_id];
                if(count($emp)>0){
                    foreach($emp as $emp_val){
                        $empId = $emp_val->getID_Employee();
                        $qty = BorrowOrReturn::report([
                            'ID_Promotion'=> $pro_id , 
                            'date_start' => $date_start , 
                            'date_end' => $date_end,
                            'ID_Employee' => $empId
                        ]);
                        $borrow = (int) $qty['borrow'];
                        $borrow_return = (int) $qty['borrow_return'];
                        $report[$empId][$pro_id] = ['emp_name' => '' ,'borrow' => $borrow ];

                    }
                }
            }
        }
        $promotion_array = json_encode($pro_name);
        $borrow_array = json_encode($borrow);
        $borrow_return_array = json_encode($borrow_return);
        //include Router::getSourcePath() . "views/admin/report_borrow.inc.php";
        include "excel_borroworreturn.php";
    }

    
    // ควรมีสำหรับ controller ทุกตัว
    private function index()
    {
        include Router::getSourcePath() . "views/login.inc.php";
    }

}