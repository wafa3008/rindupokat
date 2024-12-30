<?php
class Database
{
    private static $con = null;

    public static function Connect(): PDO
    {
        if (self::$con === null) {
            $host = "localhost";
            $username = "root";
            $password = "";

            try {
                self::$con = new PDO("mysql:host=$host;dbname=umkm", $username, $password);
                self::$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                echo "Connection failed: " . $e->getMessage();
            }
        }
        return self::$con;
    }
}
