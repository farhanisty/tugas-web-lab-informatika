<?php

namespace Farhannivta\CrudSession\Repositories;

class WaktuRepositoryFactory
{
    private static ?WaktuRepository $instance = null;

    public static function get(): WaktuRepository
    {
        if (!self::$instance) {
            self::$instance = new WaktuRepositoryImpl();
        }

        return self::$instance;
    }
}
