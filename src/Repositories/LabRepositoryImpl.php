<?php

namespace Farhannivta\CrudSession\Repositories;

use Farhannivta\CrudSession\Facades\Connection;

class LabRepositoryImpl implements LabRepository
{
    public function getAll(): array
    {
        $connection = Connection::getInstance();

        $query = 'SELECT * FROM lab';

        $stmt = $connection->query($query);

        $labs = $stmt->fetchAll(\PDO::FETCH_CLASS);

        return $labs;
    }

    public function create(string $lab): bool
    {
        $connection = Connection::getInstance();

        $query = 'INSERT INTO lab VALUE (null, ?)';

        $stmt = $connection->prepare($query);;

        $stmt->execute([$lab]);

        return $stmt->rowCount();
    }

    public function destroy(int $id): bool
    {
        $connection = Connection::getInstance();

        $query = 'DELETE FROM lab WHERE id = ?';

        $stmt = $connection->prepare($query);;

        $stmt->execute([$id]);

        return $stmt->rowCount();
    }
}
