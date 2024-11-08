<?php

namespace Farhannivta\CrudSession\Facades;

class Route
{
    public static function redirect(string $page): void
    {
        header('Location: ' . self::createUrl($page));
        die();
    }

    public static function createUrl(string $page): string
    {
        return \Config::BASE_URL . $page;
    }
}
