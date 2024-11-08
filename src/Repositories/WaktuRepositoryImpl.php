<?php

namespace Farhannivta\CrudSession\Repositories;

use Farhannivta\CrudSession\Facades\Connection;
use Farhannivta\CrudSession\Repositories\WaktuRepository;

class WaktuRepositoryImpl implements WaktuRepository
{
    public function getAll(): array
    {
        $connection = Connection::getInstance();

        $query = 'SELECT * FROM waktu';

        $stmt = $connection->query($query);

        $waktus = $stmt->fetchAll(\PDO::FETCH_CLASS);

        return $waktus;
    }

    public function destroy(int $id): bool
    {
        $connection = Connection::getInstance();

        $query = 'DELETE FROM waktu WHERE id = ?';

        $stmt = $connection->prepare($query);;

        $stmt->execute([$id]);

        return $stmt->rowCount();
    }

    public function create(string $waktuMulai, string $waktuSelesai): bool
    {
        $connection = Connection::getInstance();

        $query = 'INSERT INTO waktu VALUE (null, ?, ?)';

        $stmt = $connection->prepare($query);;

        $stmt->execute([$waktuMulai, $waktuSelesai]);

        return $stmt->rowCount();
    }
}
