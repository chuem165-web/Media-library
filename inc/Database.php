<?php

use App\Exceptions\DatabaseException;

if (!defined('BASE_PATH')) {
    define('BASE_PATH', dirname(__DIR__));
}

if (!defined('BASE_URL')) {
    define('BASE_URL', '/library');
}

class Database
{
    private static ?PDO $connection = null;

    private static string $host   = '127.0.0.1';
    private static string $dbname = 'Database01';
    private static string $user   = 'root';
    private static string $pass   = '';

    public static function getConnection(): PDO
    {
        if (self::$connection === null) {
            try {
                self::$connection = new PDO(
                    "mysql:host=" . self::$host . ";dbname=" . self::$dbname . ";charset=utf8",
                    self::$user,
                    self::$pass,
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                    ]
                );
            } catch (PDOException $e) {

                // Convert PDO error into your system exception
                throw new DatabaseException(
                    "Database connection failed"
                );
            }
        }

        return self::$connection;
    }
}