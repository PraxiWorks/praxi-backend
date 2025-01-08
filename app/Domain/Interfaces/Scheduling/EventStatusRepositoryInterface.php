<?php

namespace App\Domain\Interfaces\Scheduling;

use App\Models\Scheduling\EventStatus;

interface EventStatusRepositoryInterface
{
    public function save(EventStatus $entity): bool;
    public function getById(int $id): ?EventStatus;
    public function list(): array;
    public function update(EventStatus $entity): bool;
    public function delete(EventStatus $entity): bool;
}
