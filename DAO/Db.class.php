<?php
include('./config.ini.php');

class Db
{
    private static $instance = NULL;
    private static $dsn = DSN;
    private static $user = USER;
    private static $pass = PASS;

    private function __construct()
    {
    }

    private function __clone()
    {
    }

    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new PDO(self::$dsn, self::$user, self::$pass);
            self::$instance->query("SET NAMES UTF8");
        }
        return self::$instance;
    }
}