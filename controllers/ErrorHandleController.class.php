<?php

class ErrorHandleController {

    /**
     * handleRequest จะทำการตรวจสอบ action และพารามิเตอร์ที่ส่งเข้ามาจาก Router
     * แล้วทำการเรียกใช้เมธอดที่เหมาะสมเพื่อประมวลผลแล้วส่งผลลัพธ์กลับ
     *
     * @param string $action ชื่อ action ที่ผู้ใช้ต้องการทำ
     * @param array $params พารามิเตอร์ที่ใช้เพื่อในการทำ action หนึ่งๆ
     */
    public function handleRequest(string $action="index", array $params) {
        switch ($action) {
            case "error_handle":
                $message = $params["GET"]["message"]??"";
                $this->$action($message);
                break;
            default:
                break;
        }
    }

    private function error_handle(string $message) {
        $this->index($message);
    }

 
    // ควรมีสำหรับ controller ทุกตัว
    private function index($message) {
        include Router::getSourcePath()."views/error_handle.inc.php";
    }

}