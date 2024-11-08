<?php

namespace Farhannivta\CrudSession\Repositories;

class LabRepositoryFactory
{
    private static ?LabRepository $instance = null;

    public static function get(): LabRepository
    {
        if (!self::$instance) {
            self::$instance = new LabRepositoryImpl();
        }

        return self::$instance;
    }
}
