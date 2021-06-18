<?php
class FileController
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
            case "manage_file" :
                $this->$action();
                break;
            case "create_file":
                $FILE = isset($params["FILES"]["Path_File"]) ? $params["FILES"]["Path_File"] : "";
                $result = $this->$action($params["POST"], $FILE);
                echo $result;
                break;
            case "findById" :
                $ID_File = isset($params["POST"]["ID_File"]) ? $params["POST"]["ID_File"] : "";
                if (!empty($ID_File)) {
                    $result = $this->$action($ID_File);
                    echo $result;
                }
                break;
            case "edit_file" :
                $FILE = isset($params["FILES"]) ? $params["FILES"] : "";
                $Params= isset($params["POST"]) ? $params["POST"] : "";
                $ID_File = isset($params["GET"]["ID_File"]) ? $params["GET"]["ID_File"] : "";
                $result = $this->$action($params["POST"] ,$FILE, $ID_File);
                echo $result;
                break;
            case "delete_file":
                $params = isset($params["GET"]["ID_File"]) ? $params["GET"]["ID_File"] : "";
                $result = $this->$action($params);
                // print_r($params);
                echo $result;
                break;
            default:
                break;
        }
    }
    private function create_file($params, $FILE)
    {
        $access_file = new File();

         # สร้างไฟล์
        $Name_File =  $params["Name_File"] ;
        $Path_File = !empty($FILE) ?  $FILE['name'][0] : "" ;

        $locate = "";

        if (!empty($FILE) && !empty($FILE['name']))
        {
            $tmp_name =  $FILE['tmp_name'][0];
            $locate = Router::getSourcePath() . "uploads/" . $Path_File ;

            // copy original file to destination file
            move_uploaded_file($tmp_name, $locate);
        }

        $access_file_params = array(
            "Name_File" => $Name_File,
            "Path_File" => $locate,
        );

        $result = $access_file->create_file(
            $access_file_params
        );

        return json_encode($result);
    }
    private function findById(string $ID_File)
    {
        $file = File::findById($ID_File);//echo json_encode($employee);

        // echo json_encode(array("data" => $data_sendback));

        $data_sendback = array(
            "ID_File" => $file->getID_File(),
            "Name_FIle" => $file->getName_File(),
            "Path_File" => $file->getPath_File(),
        );

        echo json_encode(array("data" => $data_sendback));

    }
    private function edit_file($params, $FILE, $ID_File)
    {

         # อัปเดตไฟล์
        $access_file = new File();
        $ID_File = $ID_File ;
        $Name_File =  $params["Name_File"] ;

        $locate = "";

        // print_r('hello world'. '     ' . $access_news->generatePictureFilename($FILE_IMG['profile_news']['name'][0], $message_title));

        $Path_File = !empty($FILE) ?  $FILE['Name_File']['name'][0] : "" ;
        if (!empty($FILE) && !empty($FILE['Name_File']['name']))
        {
            $Name_File =  $FILE['Name_File']['name'][0];
            $Name_File_Type =  explode('.',$Name_File)[1] ;
            $tmp_name =  $FILE['Name_File']['tmp_name'][0];
            $locate = Router::getSourcePath() . "uploads/" . $Name_File . ".".$Name_File_Type;

            // copy original file to destination file
            move_uploaded_file($tmp_name, $locate);
        }

        $access_file_params = array(
            "ID_File" => ID_File,
            "Name_File" => $Name_File,
            "Path_File" => $locate,
        );


        $result = $access_file->update_file(
            $access_file_params
        );

        return json_encode($result);
    }
    private function delete_file($params) {
        $access_file = new File();
        $result = $access_file->delete_file(
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
        include Router::getSourcePath() . "views/index_admin.inc.php";

    }
    //หน้าจัดการไฟล์
    private function manage_file($params = null)
    {
        session_start();
        $employee = $_SESSION["employee"];

        # retrieve data
        $employeeList = Employee::findAll();
        $file = File::findAll();
        include Router::getSourcePath() . "views/admin/manage_file.inc.php";

    }

}