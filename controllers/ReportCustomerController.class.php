<?php

class ReportCustomerController
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
            case "customer":
                session_start();
                $this->customer();
                break;
            case "customer_print":
                session_start();
                $this->customer_print();
                break;
            case "customer2":
                session_start();
                $this->customer2();
                break;
            case "customer_print2":
                session_start();
                $this->customer_print2();
                break;
            default:
                break;
        }
    }

    private function customer()
    {
        //print_r($_SESSION);
        $employee = $_SESSION['employee'];
        $date_start = isset($_GET['date_start']) ? $_GET['date_start'] : date('Y-m-d');
        $date_end =  isset($_GET['date_end']) ? $_GET['date_end'] : date('Y-m-d');
        $cluster_shop = Cluster_Shop::findAll();

        if(count($cluster_shop)>0){
            foreach($cluster_shop as $val){
                $cluster_name[] = $val->getCluster_Shop_Name();
                $cluster_id = $val->getCluster_Shop_ID();
                $total = Invoice::customerReport($cluster_id,$date_start,$date_end);
                if($total==''){
                    $total = 0;
                }
                $company[] = (int)$total;
                $bg[] = '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
            }
        }
        
        $cluster_array = json_encode($cluster_name);
        $company_array = json_encode($company);
        $bg_array = json_encode($bg);
        include Router::getSourcePath() . "views/admin/report_customer.inc.php";
    }


    private function customer_print()
    {
        $employee = $_SESSION['employee'];
        $date_start = isset($_GET['date_start']) ? $_GET['date_start'] : date('Y-m-d');
        $date_end =  isset($_GET['date_end']) ? $_GET['date_end'] : date('Y-m-d');
        $cluster_shop = Cluster_Shop::findAll();
        $totalAll = 0;
        if(count($cluster_shop)>0){
            foreach($cluster_shop as $val){
                $cluster_name[] = $val->getCluster_Shop_Name();
                $cluster_id = $val->getCluster_Shop_ID();
                $total = Invoice::customerReport($cluster_id,$date_start,$date_end);
                if($total==''){
                    $total = 0;
                }
                $totalAll = $totalAll+$total;
                $company[] = (int)$total;
                $bg[] = '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
            }
        }
        

        $cluster_array = json_encode($cluster_name);
        $company_array = json_encode($company);
        $bg_array = json_encode($bg);
        include "report-customer.php";
    }


    private function customer2()
    {
        //print_r($_SESSION);
        $employee = $_SESSION['employee'];
        $date_start = isset($_GET['date_start']) ? $_GET['date_start'] : date('Y-m-d');
        $date_end =  isset($_GET['date_end']) ? $_GET['date_end'] : date('Y-m-d');
        $cluster_shop = Cluster_Shop::findAll();
        $totalAll = 0;
        if(count($cluster_shop)>0){
            foreach($cluster_shop as $val){
                $cluster_name[] = $val->getCluster_Shop_Name();
                $cluster_id = $val->getCluster_Shop_ID();
                $total = Invoice::customerReport2($cluster_id,$date_start,$date_end);
                if($total==''){
                    $total = 0;
                }
                $totalAll = $totalAll+$total;
                $company[] = (int)$total;
                $bg[] = '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
            }
        }
        
        $cluster_array = json_encode($cluster_name);
        $company_array = json_encode($company);
        $bg_array = json_encode($bg);
        include Router::getSourcePath() . "views/admin/report_customer2.inc.php";
    }

    private function customer_print2()
    {
        $employee = $_SESSION['employee'];
        $date_start = isset($_GET['date_start']) ? $_GET['date_start'] : date('Y-m-d');
        $date_end =  isset($_GET['date_end']) ? $_GET['date_end'] : date('Y-m-d');
        $cluster_shop = Cluster_Shop::findAll();
        $totalAll = 0;
        if(count($cluster_shop)>0){
            foreach($cluster_shop as $val){
                $cluster_name[] = $val->getCluster_Shop_Name();
                $cluster_id = $val->getCluster_Shop_ID();
                $total = Invoice::customerReport2($cluster_id,$date_start,$date_end);
                if($total==''){
                    $total = 0;
                }
                $totalAll = $totalAll+$total;
                $company[] = (int)$total;
                $bg[] = '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
            }
        }
        

        $cluster_array = json_encode($cluster_name);
        $company_array = json_encode($company);
        $bg_array = json_encode($bg);
        include "report-customer2.php";
    }



    
    // ควรมีสำหรับ controller ทุกตัว
    private function index()
    {
        include Router::getSourcePath() . "views/login.inc.php";
    }

}