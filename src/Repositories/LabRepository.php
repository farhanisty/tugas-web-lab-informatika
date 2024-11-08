<?php

namespace Farhannivta\CrudSession\Repositories;

interface LabRepository
{
    public function getAll(): array;

    public function create(string $lab): bool;

    public function destroy(int $id): bool;
}
