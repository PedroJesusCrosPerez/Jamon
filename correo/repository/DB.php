<?php

class DB
{
    private static $connection;
    private static $host = "localhost";
    private static $dbname = "erasmus";
    private static $user = "root";
    private static $password = "root";

    private function __construct()
    {
        // Constructor privado para evitar instancias no deseadas
    }

    public static function getConnection()
    {
        if (!self::$connection) {
            try {
                self::$connection = new PDO("mysql:host=" . self::$host . ";dbname=" . self::$dbname, self::$user, self::$password);
                self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Error al conectar a la base de datos: " . $e->getMessage());
            }
        }

        return self::$connection;
    }

    public static function closeConnection()
    {
        self::$connection = null;
    }
}

?>