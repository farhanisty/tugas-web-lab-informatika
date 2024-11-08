<?php

namespace Farhannivta\CrudSession\Repositories;

interface WaktuRepository
{
    public function getAll(): array;

    public function destroy(int $id): bool;

    public function create(string $waktuMulai, string $waktuSelesai): bool;
}
