<?php

declare(strict_types=1);

namespace App\Config;

use mysqli;
use Exception;

class Database
{
    private static ?mysqli $connection = null;

    public static function connect(): mysqli
    {
        if (self::$connection === null) {

            self::$connection = new mysqli(
                "localhost",
                "root",
                "",
                "company_db_simple"
            );

            if (self::$connection->connect_error) {
                throw new Exception(
                    "Database Connection Failed: " . self::$connection->connect_error
                );
            }

            self::$connection->set_charset("utf8mb4");
        }

        return self::$connection;
    }
}