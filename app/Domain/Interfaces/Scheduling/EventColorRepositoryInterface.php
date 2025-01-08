<?php

namespace App\Domain\Interfaces\Scheduling;

use App\Models\Scheduling\EventColor;

interface EventColorRepositoryInterface
{
    public function save(EventColor $entity): bool;
    public function getById(int $id): ?EventColor;
    public function list(): array;
    public function update(EventColor $entity): bool;
    public function delete(EventColor $entity): bool;
}
