<?php
class ClusterShopController
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
            case "manage_cluster_shop" :
                $this->$action();
                break;
            case "create_cluster_shop" :
                $result = $this->$action($params["POST"]);
                echo $result;
                break;
            case "edit_cluster_shop" :
                $Cluster_Shop_ID = isset($params["GET"]["Cluster_Shop_ID"]) ? $params["GET"]["Cluster_Shop_ID"] : "";
                $result = $this->$action($params["POST"], $Cluster_Shop_ID);
                echo $result;
                break;
            case "delete_cluster_shop":
                $result = $this->$action($params["POST"]["Cluster_Shop_ID"]);
                echo $result;
                break;
            case "findbyCluster_Shop_ID":
                $Cluster_Shop_ID = isset($params["POST"]["Cluster_Shop_ID"]) ? $params["POST"]["Cluster_Shop_ID"] : "";
                //print_r($Cluster_Shop_ID);exit();
                if (!empty($Cluster_Shop_ID)) {
                    $result = $this->$action($Cluster_Shop_ID);
                    echo $result;
                }
                break;
            default:
                break;
        }
    }
    private function create_cluster_shop($params)
    {
        # สร้างกลุ่มลูกค้า
        $access_cluster_shop = new Cluster_Shop();
        $cluster_shop_result = $access_cluster_shop->create_cluster_shop(
            $params
        );
        return json_encode($cluster_shop_result);
    }

    private function edit_cluster_shop($params, $Cluster_Shop_ID)
    {
        # อัปเดตกลุ่มลูกค้า
        $access_cluster_shop = new Cluster_Shop();
        $cluster_shop_result = $access_cluster_shop->edit_cluster_shop(
            $params, $Cluster_Shop_ID
        );
        echo json_encode($cluster_shop_result);

    }

    private function delete_cluster_shop($Cluster_Shop_ID)
    {
        # ลบกลุ่มลูกค้า
        $access_cluster_shop = new Cluster_Shop();
        $cluster_shop_result = $access_cluster_shop->delete_cluster_shop(
            $Cluster_Shop_ID
        );
        return json_encode($cluster_shop_result);
    }
    private function findbyCluster_Shop_ID(string $Cluster_Shop_ID)
    {
        $cluster_shop = Cluster_Shop::findById($Cluster_Shop_ID);//echo json_encode($employee);

        $data_sendback = array(
            "Cluster_Shop_ID" => $cluster_shop->getCluster_Shop_ID(),
            "Cluster_Shop_Name" => $cluster_shop->getCluster_Shop_Name(),

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
    //หน้าจัดการกลุ่มลูกค้า
    private function manage_cluster_shop($params = null)
    {
        session_start();
        $employee = $_SESSION["employee"];
        # retrieve data
        $cluster_shop = Cluster_Shop::findAll();

        include Router::getSourcePath() . "views/admin/manage_cluster_shop.inc.php";
    }
}