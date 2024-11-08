<?php

namespace Farhannivta\CrudSession\Repositories;

class JadwalRepositoryFactory
{
    private static ?JadwalRepository $instance = null;

    public static function get(): JadwalRepository
    {
        if (!self::$instance) {
            self::$instance = new JadwalRepositoryImpl();
        }

        return self::$instance;
    }
}
