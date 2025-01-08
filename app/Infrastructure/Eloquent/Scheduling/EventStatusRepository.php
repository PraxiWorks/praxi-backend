<?php

namespace App\Infrastructure\Eloquent\Scheduling;

use App\Domain\Interfaces\Scheduling\EventStatusRepositoryInterface;
use App\Models\Scheduling\EventStatus;

class EventStatusRepository implements EventStatusRepositoryInterface
{
    public function save(EventStatus $entity): bool
    {
        return $entity->save();
    }

    public function getById(int $id): ?EventStatus
    {
        return EventStatus::find($id);
    }

    public function list(): array
    {
        return EventStatus::orderBy('id')->get()->toArray();
    }

    public function update(EventStatus $entity): bool
    {
        return $entity->update();
    }

    public function delete(EventStatus $entity): bool
    {
        return $entity->delete();
    }
}
