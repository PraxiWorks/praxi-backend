<?php

namespace App\Infrastructure\Eloquent\Scheduling;

use App\Domain\Interfaces\Scheduling\EventRepositoryInterface;
use App\Models\Scheduling\Event;

class EventRepository implements EventRepositoryInterface
{
    public function save(Event $entity): bool
    {
        return $entity->save();
    }

    public function getById(int $id): ?Event
    {
        return Event::find($id);
    }

    public function list(): array
    {
        return Event::orderBy('id')->get()->toArray();
    }

    public function update(Event $entity): bool
    {
        return $entity->update();
    }

    public function delete(Event $entity): bool
    {
        return $entity->delete();
    }
}
