<?php

class Router
{

    //--------------- Properties
    private $controller; // target controller
    private $action; // action ที่ให้ทำใน controller นั้น
    private $file; // ไฟล์ที่อยู่ของ target controller
    /**
     * @var array ข้อมูลที่ส่งมาจากผู้ใช้เพื่อใช้ในการทำงาน โดยมีโครงสร้างเป็น assoc array แบบ 2 มิติ
     *      "GET" => assoc array ที่ผู้ใช้ส่งผ่านตัวแปร $_GET
     *      "POST" => assoc array ที่ผู้ใช้ส่งผ่านตัวแปร $_POST
     */
    private $params;
    private static $sourcePath; // path ของไฟล์ที่เรียกใช้ router เทียบกับ root folder

    //--------------- Constructor
    public function __construct(string $path)
    {
        self::$sourcePath = $path;
    }

    //--------------- Methods
    public static function getSourcePath(): string
    {
        return self::$sourcePath;
    }

    public function load()
    {
        $this->getController();
        $class = $this->controller . "Controller";
        $controller = new $class();
        // Call action of target controller
        $controller->handleRequest($this->action, $this->params);
    }

    private function getController()
    {
        $this->controller = $_GET['controller'] ?? "Index";
        $this->action = $_GET['action'] ?? "index";
        $this->file = "./controllers/" . $this->controller . "Controller.class.php";
        $this->params["GET"] = $_GET;
        $this->params["POST"] = $_POST;

        if (isset($_FILES)) {
            $this->params["FILES"] = $_FILES;
        }
    }
}