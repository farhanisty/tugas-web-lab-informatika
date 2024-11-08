<?php

namespace Farhannivta\CrudSession\Facades;

class Connection
{
    private static ?\PDO $instance = null;

    public static function getInstance(): \PDO
    {
        $host = \Config::DB_HOST;
        $dbname = \Config::DB_NAME;
        $username = \Config::DB_USERNAME;
        $password = \Config::DB_PASSWORD;

        if (!self::$instance) {
            try {
                $pdo = new \PDO(dsn: 'mysql:host=' . $host . ';dbname=' . $dbname, username: $username, password: $password);
                $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

                self::$instance = $pdo;
            } catch (\Exception $e) {
                die($e->getMessage());
            }
        }

        return self::$instance;
    }
}
