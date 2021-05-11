<?php
// rootPath ใช้กำหนด path ของไฟล์ปัจจุบันเทียบกับ root folder ของระบบ
$rootPath = "./";
require $rootPath . "classes/Router.class.php";

/**
 * Load Models
 */
spl_autoload_register(function ($class) {
    $path = $GLOBALS['rootPath'] . 'DAO/ActiveRecord/' . $class . '.class.php';
    if (file_exists($path))
        require_once $path;
});
spl_autoload_register(function ($class) {
    $path = $GLOBALS['rootPath'] . 'DAO/' . $class . '.class.php';
    if (file_exists($path))
        require_once $path;
});
/**
 * Load Controllers
 */
spl_autoload_register(function ($class) {
    $path = $GLOBALS['rootPath'] . 'controllers/' . $class . '.class.php';
    if (file_exists($path))
        require_once $path;
});

$router = new Router($rootPath);
$router->load();