<?php

namespace App\Infrastructure\Eloquent\Scheduling;

use App\Domain\Interfaces\Scheduling\EventTypeRepositoryInterface;
use App\Models\Scheduling\EventType;

class EventTypeRepository implements EventTypeRepositoryInterface
{
    public function save(EventType $entity): bool
    {
        return $entity->save();
    }

    public function getById(int $id): ?EventType
    {
        return EventType::find($id);
    }

    public function list(): array
    {
        return EventType::orderBy('id')->get()->toArray();
    }

    public function update(EventType $entity): bool
    {
        return $entity->update();
    }

    public function delete(EventType $entity): bool
    {
        return $entity->delete();
    }
}
