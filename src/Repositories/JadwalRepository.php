<?php

namespace Farhannivta\CrudSession\Repositories;

interface JadwalRepository
{
    public function getAll(): array;

    public function create(string $mk, string $jurusan, int $idWaktu, int $idLab): bool;

    public function destroy(int $id): bool;

    public function update(int $id, string $mk, string $jurusan, int $idWaktu, int $idLab): bool;

    public function getById(int $id): ?object;
}
