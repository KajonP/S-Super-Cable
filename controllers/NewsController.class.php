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
                $ID_Employee = isset($params["GET"]["ID_Employee"]) ? $params["GET"]["ID_Employee"] : "";
                $FILE_IMG = isset($params["FILES"]["profile_news"]) ? $params["FILES"]["profile_news"] : "";
                $result = $this->$action($params["POST"], $FILE_IMG, $ID_Employee);
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
            case "show_news_status":
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
                    include Router::getSourcePath() . "views/user/index_news.inc.php";
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
                    include Router::getSourcePath() . "views/user/redirect_index_news.inc.php";
                }
                break;
            default:
                break;
        }
    }
    private static function create_news($params, $FILE_IMG, $emp_id)
    {
        // # สร้างข่าวสารร
        $access_news = new Message();
        $messageid = $access_news->geneateDateTimemd() ;
        $message_title =  $params["Tittle_Message"] ;
        $message_text  =  isset($params["Text_Message"]) ?  $params["Text_Message"] : "";

        // print_r('hello world'. '     ' . $access_news->generatePictureFilename($FILE_IMG['name'][0], $message_title));

        $message_filename = !empty($FILE_IMG['name'][0]) ?  $access_news->generatePictureFilename($FILE_IMG['name'][0], $message_title) : "" ;
        $message_filename2 = !empty($FILE_IMG['name'][1]) ?  $access_news->generatePictureFilename($FILE_IMG['name'][1], $message_title) : "" ;
        $message_filename3 = !empty($FILE_IMG['name'][2]) ?  $access_news->generatePictureFilename($FILE_IMG['name'][2], $message_title) : "" ;
        $message_datetime = $access_news->geneateDateTime();
        $locate_img = "";
        $locate_img2 = "";
        $locate_img3 = "";
        //echo ">>".$FILE_IMG['name'][1];
        if (!empty($FILE_IMG) && !empty($FILE_IMG['name'][0]))
        {
            $name_file =  $FILE_IMG['name'][0];
            $name_file_type =  explode('.',$name_file)[1] ;
            $tmp_name =  $FILE_IMG['tmp_name'][0];
            $locate_img = Router::getSourcePath() . "images/" . $message_filename . ".".$name_file_type;

            // copy original file to destination file
            move_uploaded_file($tmp_name, $locate_img);
        }

        if (!empty($FILE_IMG) && !empty($FILE_IMG['name'][1]))
        {
            $name_file2 =  $FILE_IMG['name'][1];
            $name_file_type2 =  explode('.',$name_file2)[1] ;
            $tmp_name2 =  $FILE_IMG['tmp_name'][1];
            $locate_img2 = Router::getSourcePath() . "images/" . $message_filename2 . ".".$name_file_type2;

            // copy original file to destination file
            move_uploaded_file($tmp_name2, $locate_img2);
        }

        if (!empty($FILE_IMG) && !empty($FILE_IMG['name'][2]))
        {
            $name_file3 =  $FILE_IMG['name'][2];
            $name_file_type3 =  explode('.',$name_file3)[1] ;
            $tmp_name3 =  $FILE_IMG['tmp_name'][2];
            $locate_img3 = Router::getSourcePath() . "images/" . $message_filename3 . ".".$name_file_type3;

            // copy original file to destination file
            move_uploaded_file($tmp_name3, $locate_img3);
        }

        $access_news_params = array(
            "ID_Message" => $messageid,
            "Tittle_Message" => $message_title,
            "Text_Message" => $message_text,
            "Picture_Message" => $locate_img,
            "Picture_Message2" => $locate_img2,
            "Picture_Message3" => $locate_img3,
            "Date_Message"=> $message_datetime,
        );

        $result = $access_news->create_news(
            $access_news_params, $emp_id
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
            "Picture_Message2" => $message->getPicture_Message2(),
            "Picture_Message3" => $message->getPicture_Message3(),
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
        $locate_img2 = "";
        $locate_img3 = "";

        // print_r('hello world'. '     ' . $access_news->generatePictureFilename($FILE_IMG['profile_news']['name'][0], $message_title));
        //print_r($FILE_IMG['profile_news']);
        $message_filename = !empty($FILE_IMG['profile_news']['name'][0]) ?  $access_news->generatePictureFilename($FILE_IMG['profile_news']['name'][0], $message_title) : "" ;

        $message_filename2 = !empty($FILE_IMG['profile_news']['name'][1]) ?  $access_news->generatePictureFilename($FILE_IMG['profile_news']['name'][1], $message_title) : "" ;

         $message_filename3 = !empty($FILE_IMG['profile_news']['name'][2]) ?  $access_news->generatePictureFilename($FILE_IMG['profile_news']['name'][2], $message_title) : "" ;
         
        if (!empty($FILE_IMG) && !empty($FILE_IMG['profile_news']['name']))
        {
            $name_file =  $FILE_IMG['profile_news']['name'][0];
            $name_file_type =  explode('.',$name_file)[1] ;
            $tmp_name =  $FILE_IMG['profile_news']['tmp_name'][0];
            $locate_img = Router::getSourcePath() . "images/" . $message_filename . ".".$name_file_type;

            // copy original file to destination file
            move_uploaded_file($tmp_name, $locate_img);
        }

         if (!empty($FILE_IMG) && !empty($FILE_IMG['profile_news']['name'][1]))
        {
            $name_file2 =  $FILE_IMG['profile_news']['name'][1];
            $name_file_type2 =  explode('.',$name_file2)[1] ;
            $tmp_name2 =  $FILE_IMG['profile_news']['tmp_name'][1];
            $locate_img2 = Router::getSourcePath() . "images/" . $message_filename2 . ".".$name_file_type2;

            // copy original file to destination file
            move_uploaded_file($tmp_name2, $locate_img2);
        }

        if (!empty($FILE_IMG) && !empty($FILE_IMG['profile_news']['name'][2]))
        {
            $name_file3 =  $FILE_IMG['profile_news']['name'][2];
            $name_file_type3 =  explode('.',$name_file3)[1] ;
            $tmp_name3 =  $FILE_IMG['profile_news']['tmp_name'][2];
            $locate_img3 = Router::getSourcePath() . "images/" . $message_filename3 . ".".$name_file_type3;

            // copy original file to destination file
            move_uploaded_file($tmp_name3, $locate_img3);
        }

        $access_news_params = array(
            "ID_Message" => $messageid,
            "Tittle_Message" => $message_title,
            "Text_Message" => $message_text,
            "Picture_Message" => $locate_img,
            "Picture_Message2" => $locate_img2,
            "Picture_Message3" => $locate_img3,
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
        include Router::getSourcePath() . "views/login.inc.php";
    }
    //หน้าจัดการข่าวสาร
    private function manage_news($params = null)
    {
        session_start();
        $employee = $_SESSION["employee"];

        # retrieve data
        $employeeList = Employee::findAll();
        $message = Message::fetchAll();
        include Router::getSourcePath() . "views/admin/manage_news.inc.php";

    }

}