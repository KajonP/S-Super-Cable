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
                $ID_Employee = isset($params["GET"]["ID_Employee"]) ? $params["GET"]["ID_Employee"] : "";
                $FILE_IMG = isset($params["FILES"]["award_pic"]) ? $params["FILES"]["award_pic"] : "";
                $result = $this->$action($params["POST"], $FILE_IMG,$ID_Employee);
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
            case "show_award_status":
                session_start();
                $employee = $_SESSION['employee'];

                if ($employee->getUser_Status_Employee() == "Admin") {
                    include Router::getSourcePath() . "views/index_admin.inc.php";
                } else if ($employee->getUser_Status_Employee() == "Sales") {
                    # retrieve data
                    $countAll = Award::fetchCountAll($employee->getID_Employee());
                    $n = $countAll[0];
                    $count_page = ceil($n/4);
                    $start = 0;
                    $get_page = 1;
                    if(isset($_GET['page'])){
                        $get_page = $_GET['page'];
                    }
                    $start = ($get_page*4)-4;
                    $award = Award::fetchAllwithInnerLimit($employee->getID_Employee(),$start,4);
                    
                    //echo $n.':'.$count_page;
                    //exit;
                    include Router::getSourcePath() . "views/sales/index_award.inc.php";
                } else if ($employee->getUser_Status_Employee() == "User") {
                    # retrieve data
                    $countAll = Award::fetchCountAll($employee->getID_Employee());
                    $n = $countAll[0];
                    $count_page = ceil($n/4);
                    $start = 0;
                    $get_page = 1;
                    if(isset($_GET['page'])){
                        $get_page = $_GET['page'];
                    }
                    $start = ($get_page*4)-4;
                    $award = Award::fetchAllwithInnerLimit($employee->getID_Employee(),$start,4);
                    //echo $n.':'.$count_page;
                    //exit;
                    include Router::getSourcePath() . "views/user/index_award.inc.php";
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
                    include Router::getSourcePath() . "views/sales/redirect_index_award.inc.php";
                } else if ($employee->getUser_Status_Employee() == "User") {
                    # retrieve data
                    $award = Award::update_award_status($employee->getID_Employee(), $ID_Award);
                    include Router::getSourcePath() . "views/user/redirect_index_award.inc.php";

                }
                break;
            case "show" :
                session_start();
                $employee = $_SESSION['employee'];
                Award::update_award_status($employee->getID_Employee(), $_GET['id']);
                $this->show();
                break;
            default:
                break;
        }
    }
    private function create_award($params, $FILE_IMG)
    {
        $access_award = new Award();

        // # สร้างรางวัล
        $awardid = $access_award->geneateDateTimemd() ;
        $award_title =  $params["Tittle_Award"] ;
        $award_filename = !empty($FILE_IMG['name'][0]) ?  $access_award->generatePictureFilename($FILE_IMG['name'][0], $award_title) : "" ;
        $award_filename2 = !empty($FILE_IMG['name'][1]) ?  $access_award->generatePictureFilename($FILE_IMG['name'][1], $award_title) : "" ;
        $award_filename3 = !empty($FILE_IMG['name'][2]) ?  $access_award->generatePictureFilename($FILE_IMG['name'][2], $award_title) : "" ;

        $award_datetime = $access_award->geneateDateTime();
        $locate_img = "";
        $locate_img2 = "";
        $locate_img3 = "";
        $award_ID_Employee = $params["ID_Employee"];

        if (!empty($FILE_IMG) && !empty($FILE_IMG['name'][0]))
        {
            $name_file =  $FILE_IMG['name'][0];
            $name_file_type =  explode('.',$name_file)[1] ;
            $tmp_name =  $FILE_IMG['tmp_name'][0];
            $locate_img = Router::getSourcePath() . "images/" . $award_filename . ".".$name_file_type;

            // copy original file to destination file
            move_uploaded_file($tmp_name, $locate_img);
        }

        if (!empty($FILE_IMG) && !empty($FILE_IMG['name'][1]))
        {
            $name_file2 =  $FILE_IMG['name'][1];
            $name_file_type2 =  explode('.',$name_file2)[1] ;
            $tmp_name2 =  $FILE_IMG['tmp_name'][1];
            $locate_img2 = Router::getSourcePath() . "images/" . $award_filename2 . ".".$name_file_type2;

            // copy original file to destination file
            move_uploaded_file($tmp_name2, $locate_img2);
        }

        if (!empty($FILE_IMG) && !empty($FILE_IMG['name'][2]))
        {
            $name_file3 =  $FILE_IMG['name'][2];
            $name_file_type3 =  explode('.',$name_file3)[1] ;
            $tmp_name3 =  $FILE_IMG['tmp_name'][2];
            $locate_img3 = Router::getSourcePath() . "images/" . $award_filename3 . ".".$name_file_type3;

            // copy original file to destination file
            move_uploaded_file($tmp_name3, $locate_img3);
        }
        $access_award_params = array(
            "ID_Award" => $awardid,
            "Tittle_Award" => $award_title,
            "Picture_Award" => $locate_img,
            "Picture_Award2" => $locate_img2,
            "Picture_Award3" => $locate_img3,
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
            "Picture_Award2" => $award->getPicture_Award2(),
            "Picture_Award3" => $award->getPicture_Award3(),
            "Date_Award" => $award->getDate_Award(),
            "ID_Employee" => $award->getID_Employee(),
        );

        echo json_encode(array("data" => $data_sendback));
    }


    private function edit_award($params, $FILE_IMG, $ID_Award)
    {
        $awardOld = Award::findAward_byID($ID_Award);
        // # อัปเดตรางวัล
        $access_award = new Award();
        $awardid = $ID_Award ;
        $award_title =  $params["Tittle_Award"] ;
        $award_datetime = $access_award->geneateDateTime();

        $locate_img = "";
        $locate_img2 = "";
        $locate_img3 = "";

        // print_r('hello world'. '     ' . $access_news->generatePictureFilename($FILE_IMG['profile_news']['name'][0], $message_title));

        $award_filename = !empty($FILE_IMG['award_pic']['name'][0]) ?  $access_award->generatePictureFilename($FILE_IMG['award_pic']['name'][0], $award_title) : $awardOld->getPicture_Award() ;
        $award_filename2 = !empty($FILE_IMG['award_pic']['name'][1]) ?  $access_award->generatePictureFilename($FILE_IMG['award_pic']['name'][1], $award_title) : $awardOld->getPicture_Award2() ;
        $award_filename3 = !empty($FILE_IMG['award_pic']['name'][2]) ?  $access_award->generatePictureFilename($FILE_IMG['award_pic']['name'][2], $award_title) : $awardOld->getPicture_Award3() ;

        if (!empty($FILE_IMG) && !empty($FILE_IMG['award_pic']['name'][0]))
        {
            $name_file =  $FILE_IMG['award_pic']['name'][0];
            $name_file_type =  explode('.',$name_file)[1] ;
            $tmp_name =  $FILE_IMG['award_pic']['tmp_name'][0];
            $locate_img = Router::getSourcePath() . "images/" . $award_filename . ".".$name_file_type;

            // copy original file to destination file
            move_uploaded_file($tmp_name, $locate_img);
        }

         if (!empty($FILE_IMG) && !empty($FILE_IMG['award_pic']['name'][1]))
         {
             $name_file2 =  $FILE_IMG['award_pic']['name'][1];
             $name_file_type2 =  explode('.',$name_file2)[1] ;
             $tmp_name2 =  $FILE_IMG['award_pic']['tmp_name'][1];
             $locate_img2 = Router::getSourcePath() . "images/" . $award_filename2 . ".".$name_file_type2;

             // copy original file to destination file
             move_uploaded_file($tmp_name2, $locate_img2);
         }

        if (!empty($FILE_IMG) && !empty($FILE_IMG['award_pic']['name'][2]))
        {
            $name_file3 =  $FILE_IMG['award_pic']['name'][2];
            $name_file_type3 =  explode('.',$name_file3)[1] ;
            $tmp_name3 =  $FILE_IMG['award_pic']['tmp_name'][2];
            $locate_img3 = Router::getSourcePath() . "images/" . $award_filename3 . ".".$name_file_type3;
            // copy original file to destination file
            move_uploaded_file($tmp_name3, $locate_img3);
        }
        $access_award_params = array(
            "ID_Award" => $awardid,
            "Tittle_Award" => $award_title,
            "Picture_Award" => $locate_img,
            "Picture_Award2" => $locate_img2,
            "Picture_Award3" => $locate_img3,
            "Date_Award"=> $award_datetime,
        );

        //print_r($access_award_params);
        
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
        include Router::getSourcePath() . "views/login.inc.php";

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
    private function show($params = null)
    {

        $employee = $_SESSION["employee"];

        $award = Award::findAward_byID($_GET['id']);
        if ($employee->getUser_Status_Employee() == "Admin") {
            include Router::getSourcePath() . "views/index_admin.inc.php";
        } else if ($employee->getUser_Status_Employee() == "Sales") {
            include Router::getSourcePath() . "views/sales/award.inc.php";
        } else if ($employee->getUser_Status_Employee() == "User") {
            include Router::getSourcePath() . "views/user/award.inc.php";
        }
    }

}