<?php

class AwardController
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
            case "manage_award" :
                $this->$action();
                break;
            case "create_award":
                $FILE_IMG = isset($params["FILES"]["award_pic"]) ? $params["FILES"]["award_pic"] : "";
                $result = $this->$action($params["POST"], $FILE_IMG);
                echo $result;
                break;
            case "findAwardbyID_Award" :
                $ID_Award = isset($params["POST"]["ID_Award"]) ? $params["POST"]["ID_Award"] : "";
                if (!empty($ID_Award)) {
                    $result = $this->$action($ID_Award);
                    echo $result;
                }
                break;
            case "edit_award" :
                $FILE_IMG = isset($params["FILES"]) ? $params["FILES"] : "";
                $Params= isset($params["POST"]) ? $params["POST"] : "";
                $ID_Award = isset($params["GET"]["ID_Award"]) ? $params["GET"]["ID_Award"] : "";
                $result = $this->$action($params["POST"] ,$FILE_IMG, $ID_Award);
                echo $result;
                break;
            case "delete_award":
                $params = isset($params["GET"]["ID_Award"]) ? $params["GET"]["ID_Award"] : "";
                $result = $this->$action($params);
                // print_r($params);
                echo $result;
                break;
            default:
                break;
        }
    }
    private function create_award($params, $FILE_IMG)
    {
        $access_award = new Award();

        // # สร้างข่าวสารร
        $awardid = $access_award->geneateDateTimemd() ;
        $award_title =  $params["Tittle_Award"] ;
        $award_filename = !empty($FILE_IMG) ?  $access_award->generatePictureFilename($FILE_IMG['name'][0], $award_title) : "" ;
        $award_datetime = $access_award->geneateDateTime();
        $locate_img = "";
        $award_ID_Employee = $params["ID_Employee"];

        if (!empty($FILE_IMG) && !empty($FILE_IMG['name']))
        {
            $name_file =  $FILE_IMG['name'][0];
            $name_file_type =  explode('.',$name_file)[1] ;
            $tmp_name =  $FILE_IMG['tmp_name'][0];
            $locate_img = Router::getSourcePath() . "images/" . $award_filename . ".".$name_file_type;

            // copy original file to destination file
            move_uploaded_file($tmp_name, $locate_img);
        }

        $access_award_params = array(
            "ID_Award" => $awardid,
            "Tittle_Award" => $award_title,
            "Picture_Award" => $locate_img,
            "Date_Award"=> $award_datetime,
            "ID_Employee" => $award_ID_Employee,
        );

        $result = $access_award->create_award(
            $access_award_params
        );

        return json_encode($result);
    }



    private function findAwardbyID_Award($findbyID_Award)
    {
        $award = Award::findAward_byID($findbyID_Award);//echo json_encode($employee);

        // echo json_encode(array("data" => $data_sendback));

        $data_sendback = array(
            "ID_Award" => $award->getID_Award(),
            "Tittle_Award" => $award->getTittle_Award(),
            "Picture_Award" => $award->getPicture_Award(),
            "Date_Award" => $award->getDate_Award(),
            "ID_Employee" => $award->getID_Employee(),
        );

        echo json_encode(array("data" => $data_sendback));
    }


    private function edit_award($params, $FILE_IMG, $ID_Award)
    {

        // # สร้างข่าวสารร
        $access_award = new Award();
        $awardid = $ID_Award ;
        $award_title =  $params["Tittle_Award"] ;
        $award_datetime = $access_award->geneateDateTime();

        $locate_img = "";

        // print_r('hello world'. '     ' . $access_news->generatePictureFilename($FILE_IMG['profile_news']['name'][0], $message_title));

        $award_filename = !empty($FILE_IMG) ?  $access_award->generatePictureFilename($FILE_IMG['award_pic']['name'][0], $award_title) : "" ;
        if (!empty($FILE_IMG) && !empty($FILE_IMG['award_pic']['name']))
        {
            $name_file =  $FILE_IMG['award_pic']['name'][0];
            $name_file_type =  explode('.',$name_file)[1] ;
            $tmp_name =  $FILE_IMG['award_pic']['tmp_name'][0];
            $locate_img = Router::getSourcePath() . "images/" . $award_filename . ".".$name_file_type;

            // copy original file to destination file
            move_uploaded_file($tmp_name, $locate_img);
        }

        $access_award_params = array(
            "ID_Award" => $awardid,
            "Tittle_Award" => $award_title,
            "Picture_Award" => $locate_img,
            "Date_Award"=> $award_datetime,
        );


        $result = $access_award->update_award(
            $access_award_params
        );

        return json_encode($result);

    }

    private function delete_award($params) {
        $access_award = new Award();
        $result = $access_award->delete_award(
            $params
        );
        // print_r($result);
        return json_encode($result);
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
    //หน้าจัดการรางวัล
    private function manage_award()
    {
        session_start();
        $employee = $_SESSION["employee"];

        # retrieve data

        $employeeList = Employee::findAll();
        $awardList = Award::fetchAll();


        include Router::getSourcePath() . "views/admin/manage_award.inc.php";
    }

}