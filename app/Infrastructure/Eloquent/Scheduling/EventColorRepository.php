<?php

namespace App\Infrastructure\Eloquent\Scheduling;

use App\Domain\Interfaces\Scheduling\EventColorRepositoryInterface;
use App\Models\Scheduling\EventColor;

class EventColorRepository implements EventColorRepositoryInterface
{
    public function save(EventColor $entity): bool
    {
        return $entity->save();
    }

    public function getById(int $id): ?EventColor
    {
        return EventColor::find($id);
    }

    public function list(): array
    {
        return EventColor::orderBy('id')->get()->toArray();
    }

    public function update(EventColor $entity): bool
    {
        return $entity->update();
    }

    public function delete(EventColor $entity): bool
    {
        return $entity->delete();
    }
}
