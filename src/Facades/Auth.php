<?php

namespace Farhannivta\CrudSession\Facades;

use Farhannivta\CrudSession\Facades\Connection;
use Farhannivta\CrudSession\Facades\Route;

class Auth
{
    public static function login(string $username, string $password): bool
    {
        if (self::isLogged()) {
            Route::redirect('');
        }

        $connection = Connection::getInstance();

        $query = 'SELECT * FROM user WHERE username = ? AND password = ?';

        $stmt = $connection->prepare($query);

        $stmt->execute([$username, $password]);

        $isValid = $stmt->fetchObject() ? true : false;

        if ($isValid) {
            $_SESSION['login'] = true;
        }

        return $isValid;
    }

    public static function register(string $username, string $password): bool
    {
        if (self::isLogged()) {
            Route::redirect('');
        }

        $connection = Connection::getInstance();

        $query = 'INSERT INTO user VALUE (null, ?, ?)';
        $stmt = $connection->prepare($query);
        $stmt->execute([$username, $password]);

        return ($stmt->rowCount()) ? true : false;
    }

    public static function isLogged(): bool
    {
        return isset($_SESSION['login']) ? true : false;
    }

    public static function logout(): bool
    {
        if (!self::isLogged()) {
            return false;
        }

        unset($_SESSION['login']);
        return true;
    }
}
