<?php

namespace Farhannivta\CrudSession\Repositories;

use Farhannivta\CrudSession\Facades\Connection;
use Farhannivta\CrudSession\Repositories\JadwalRepository;

class JadwalRepositoryImpl implements JadwalRepository
{
    public function getAll(): array
    {
        $connection = Connection::getInstance();

        $query = 'SELECT j.id, j.mk, j.jurusan, w.waktu_mulai, w.waktu_selesai, l.lab FROM jadwal j JOIN waktu w ON w.id = j.id_waktu JOIN lab l ON l.id = j.id_lab';

        $stmt = $connection->query($query);

        $jadwals = $stmt->fetchAll(\PDO::FETCH_CLASS);

        return $jadwals;
    }

    public function getById(int $id): ?object
    {
        $connection = Connection::getInstance();

        $query = 'SELECT j.id, j.mk, j.jurusan,w.id as id_waktu, w.waktu_mulai, w.waktu_selesai, l.id as id_lab, l.lab FROM jadwal j JOIN waktu w ON w.id = j.id_waktu JOIN lab l ON l.id = j.id_lab WHERE j.id = ?';

        $stmt = $connection->prepare($query);

        $stmt->execute([$id]);

        return $stmt->fetchObject();
    }

    public function destroy(int $id): bool
    {
        $connection = Connection::getInstance();

        $query = 'DELETE FROM jadwal WHERE id = ?';

        $stmt = $connection->prepare($query);;

        $stmt->execute([$id]);

        return $stmt->rowCount();
    }

    public function update(
        int $id,
        string $mk,
        string $jurusan,
        int $idLab,
        int $idWaktu
    ): bool {
        $connection = Connection::getInstance();

        $query = 'UPDATE jadwal SET mk=?, jurusan=?, id_lab=?, id_waktu=? WHERE id=?';

        $stmt = $connection->prepare($query);;

        $stmt->execute([$mk, $jurusan, $idLab, $idWaktu, $id]);

        return $stmt->rowCount();
    }

    public function create(
        string $mk,
        string $jurusan,
        int $idLab,
        int $idWaktu
    ): bool {
        $connection = Connection::getInstance();

        $query = 'INSERT INTO jadwal VALUE (null, ?, ?, ?, ?)';

        $stmt = $connection->prepare($query);;

        $stmt->execute([$mk, $jurusan, $idLab, $idWaktu]);

        return $stmt->rowCount();
    }

    // public function create(string $jadwalMulai, string $jadwalSelesai): bool;
}
