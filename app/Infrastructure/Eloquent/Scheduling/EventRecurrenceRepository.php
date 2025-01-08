<?php

namespace App\Infrastructure\Eloquent\Scheduling;

use App\Domain\Interfaces\Scheduling\EventRecurrenceRepositoryInterface;
use App\Models\Scheduling\EventRecurrence;

class EventRecurrenceRepository implements EventRecurrenceRepositoryInterface
{
    public function save(EventRecurrence $entity): bool
    {
        return $entity->save();
    }

    public function getById(int $id): ?EventRecurrence
    {
        return EventRecurrence::find($id);
    }

    public function list(): array
    {
        return EventRecurrence::orderBy('id')->get()->toArray();
    }

    public function update(EventRecurrence $entity): bool
    {
        return $entity->update();
    }

    public function delete(EventRecurrence $entity): bool
    {
        return $entity->delete();
    }
}
