<?php

namespace App\Domain\Interfaces\Scheduling;

use App\Models\Scheduling\EventRecurrence;

interface EventRecurrenceRepositoryInterface
{
    public function save(EventRecurrence $entity): bool;
    public function getById(int $id): ?EventRecurrence;
    public function list(): array;
    public function update(EventRecurrence $entity): bool;
    public function delete(EventRecurrence $entity): bool;
}
