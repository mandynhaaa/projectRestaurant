<?php

namespace Connection;

class Connection
{
    private static $servername = "mysql";
    private static $port = 3306;
    private static $username = "root";
    private static $password = "admin";
    private static $dbname = "dbRestaurant";
    private static $conn = null;

    public static function getConnection() 
    {
        if (self::$conn === null) {
            try {
                self::$conn = new \PDO(
                    "mysql:host=" . self::$servername . ";port=" . self::$port . ";", 
                    self::$username, 
                    self::$password
                );
                self::$conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
                self::$conn->exec("USE " . self::$dbname);
            } catch (\PDOException $e) {
                throw new \Exception("Connection failed: " . $e->getMessage());
            }
        }
        return self::$conn;
    }
}
