<?php

namespace App\Domain\Interfaces\Scheduling;

use App\Models\Scheduling\EventType;

interface EventTypeRepositoryInterface
{
    public function save(EventType $entity): bool;
    public function getById(int $id): ?EventType;
    public function list(): array;
    public function update(EventType $entity): bool;
    public function delete(EventType $entity): bool;
}
