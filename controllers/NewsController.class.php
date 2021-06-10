<?php

class NewsController
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
            case "manage_news" :
                $this->$action();
                break;
            case "create_news" :
                $FILE_IMG = isset($params["FILES"]["profile_news"]) ? $params["FILES"]["profile_news"] : "";
                $result = $this->$action($params["POST"], $FILE_IMG);
                echo $result;
                break;
            case "findbyID_Message":
                $ID_Message = isset($params["POST"]["ID_Message"]) ? $params["POST"]["ID_Message"] : "";
                if (!empty($ID_Message)) {
                    $result = $this->$action($ID_Message);
                    echo $result;
                }
                break;
            case "edit_news":
                $FILE_IMG = isset($params["FILES"]) ? $params["FILES"] : "";
                $Params= isset($params["POST"]) ? $params["POST"] : "";
                $ID_Message = isset($params["GET"]["ID_Message"]) ? $params["GET"]["ID_Message"] : "";
                $result = $this->$action($params["POST"] ,$FILE_IMG, $ID_Message);
                echo $result;
                break;
            case "delete_news":
                $params = isset($params["GET"]["ID_Message"]) ? $params["GET"]["ID_Message"] : "";
                $result = $this->$action($params);
                // print_r($params);
                echo $result;
                break;
            default:
                break;
        }
    }
    private static function create_news($params, $FILE_IMG)
    {
        // # สร้างข่าวสารร
        $access_news = new Message();
        $messageid = $access_news->geneateDateTimemd() ;
        $message_title =  $params["Tittle_Message"] ;
        $message_text  =  isset($params["Text_Message"]) ?  $params["Text_Message"] : "";

        // print_r('hello world'. '     ' . $access_news->generatePictureFilename($FILE_IMG['name'][0], $message_title));

        $message_filename = !empty($FILE_IMG) ?  $access_news->generatePictureFilename($FILE_IMG['name'][0], $message_title) : "" ;
        $message_datetime = $access_news->geneateDateTime();
        $locate_img = "";

        if (!empty($FILE_IMG) && !empty($FILE_IMG['name']))
        {
            $name_file =  $FILE_IMG['name'][0];
            $name_file_type =  explode('.',$name_file)[1] ;
            $tmp_name =  $FILE_IMG['tmp_name'][0];
            $locate_img = Router::getSourcePath() . "images/" . $message_filename . ".".$name_file_type;

            // copy original file to destination file
            move_uploaded_file($tmp_name, $locate_img);
        }

        $access_news_params = array(
            "ID_Message" => $messageid,
            "Tittle_Message" => $message_title,
            "Text_Message" => $message_text,
            "Picture_Message" => $locate_img,
            "Date_Message"=> $message_datetime,
        );

        $result = $access_news->create_news(
            $access_news_params
        );

        return json_encode($result);
    }

    private function findbyID_Message($findbyID_Message)
    {
        $message = Message::findById($findbyID_Message);//echo json_encode($employee);

        // echo json_encode(array("data" => $data_sendback));

        $data_sendback = array(
            "ID_Message" => $message->getID_Message(),
            "Tittle_Message" => $message->getTittle_Message(),
            "Text_Message" => $message->getText_Message(),
            "Picture_Message" => $message->getPicture_Message(),
            "Date_Message" => $message->getDate_Message(),
        );

        echo json_encode(array("data" => $data_sendback));

    }

    private function edit_news($params, $FILE_IMG, $ID_Message)
    {

        // # สร้างข่าวสารร
        $access_news = new Message();
        $messageid = $ID_Message ;
        $message_title =  $params["Tittle_Message"] ;
        $message_text  =  isset($params["Text_Message"]) ?  $params["Text_Message"] : "";
        $message_datetime = $access_news->geneateDateTime();

        $locate_img = "";

        // print_r('hello world'. '     ' . $access_news->generatePictureFilename($FILE_IMG['profile_news']['name'][0], $message_title));

        $message_filename = !empty($FILE_IMG) ?  $access_news->generatePictureFilename($FILE_IMG['profile_news']['name'][0], $message_title) : "" ;
        if (!empty($FILE_IMG) && !empty($FILE_IMG['profile_news']['name']))
        {
            $name_file =  $FILE_IMG['profile_news']['name'][0];
            $name_file_type =  explode('.',$name_file)[1] ;
            $tmp_name =  $FILE_IMG['profile_news']['tmp_name'][0];
            $locate_img = Router::getSourcePath() . "images/" . $message_filename . ".".$name_file_type;

            // copy original file to destination file
            move_uploaded_file($tmp_name, $locate_img);
        }

        $access_news_params = array(
            "ID_Message" => $messageid,
            "Tittle_Message" => $message_title,
            "Text_Message" => $message_text,
            "Picture_Message" => $locate_img,
            "Date_Message"=> $message_datetime,
        );


        $result = $access_news->update_news(
            $access_news_params
        );

        return json_encode($result);
    }

    private function delete_news($params) {
        $access_message = new Message();
        $result = $access_message->delete_news(
            $params
        );
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
        include Router::getSourcePath() . "views/index_sales.inc.php";

    }
    //หน้าจัดการข่าวสาร
    private function manage_news($params = null)
    {
        session_start();
        $employee = $_SESSION["employee"];

        # retrieve data

        $message = Message::fetchAll();

        $file_log = Filelog::findByPage('manage_news');


        include Router::getSourcePath() . "views/admin/manage_news.inc.php";

    }

}