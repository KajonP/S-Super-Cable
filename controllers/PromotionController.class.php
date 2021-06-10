<?php


class PromotionController
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
            case "manage_promotion" :
                $this->$action();
                break;
            case "create_promotion" :
                $result = $this->$action($params["POST"]);
                echo $result;
                break;
            case "edit_promotion" :
                $ID_Promotion = isset($params["GET"]["ID_Promotion"]) ? $params["GET"]["ID_Promotion"] : "";
                $result = $this->$action($params["POST"], $ID_Promotion);
                echo $result;
                break;
            case "delete_promotion":
                $result = $this->$action($params["POST"]["ID_Promotion"]);
                echo $result;
                break;
            case "findbyID_Promotion":
                $ID_Promotion = isset($params["POST"]["ID_Promotion"]) ? $params["POST"]["ID_Promotion"] : "";

                if (!empty($ID_Promotion)) {
                    $result = $this->$action($ID_Promotion);
                    echo $result;
                }
                break;
            default:
                break;
        }
    }
    private function create_promotion($params)
    {
        # สร้างสินค้าส่งเสริมการขาย
        $access_promotion = new Promotion();

        $promotion_result = $access_promotion->create_promotion(
            $params
        );
        return json_encode($promotion_result);
    }

    private function edit_promotion($params, $ID_Promotion)
    {
        # อัปเดตสินค้าส่งเสริมการขาย
        $access_promotion = new Promotion();
        $promotion_result = $access_promotion->edit_promotion(
            $params, $ID_Promotion
        );
        echo json_encode($promotion_result);

    }

    private function delete_promotion($ID_Promotion)
    {
        # ลบสินค้าส่งเสริมการขาย
        $access_promotion = new Promotion();
        $promotion_result = $access_promotion->delete_promotion(
            $ID_Promotion
        );
        return json_encode($promotion_result);
    }

    private function findbyID_Promotion(string $ID_Promotion)
    {
        $promotion = Promotion::findById($ID_Promotion);//echo json_encode($sales);


        $data_sendback = array(
            "ID_Promotion" => $promotion->getID_Promotion(),
            "Name_Promotion" => $promotion->getName_Promotion(),
            "Unit_Promotion" => $promotion->getUnit_Promotion(),
            "Price_Unit_Promotion" => $promotion->getPrice_Unit_Promotion(),

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
        session_start();
        $employee = $_SESSION["employee"];
        include Router::getSourcePath() . "views/index_admin.inc.php";
    }
    //หน้าจัดการสินค้าส่งเสริมการขาย
    private function manage_promotion($params = null)
    {
        session_start();
        $employee = $_SESSION["employee"];

        # retrieve data
        $promotionList = Promotion::findAll();

        include Router::getSourcePath() . "views/admin/manage_promotion.inc.php";
    }

}