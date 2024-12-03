<?php

class Database{
    private static $db_name = "gestion_stock_dclic";
    private static $db_host = "localhost";
    private static $db_user = "root";
    private static $db_password = "";
    private static $db_charset = "utf8";
    private static $db = null;

    public static function Connect(){
        self::$db = new PDO("mysql:host=".self::$db_host.";dbname=".self::$db_name.";charset=".self::$db_charset, self::$db_user, self::$db_password);
        return self::$db;
    }

    public static function Disconnect(){
        self::$db = null;
    }
}