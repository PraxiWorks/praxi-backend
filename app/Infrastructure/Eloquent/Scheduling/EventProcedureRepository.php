<?php

namespace App\Infrastructure\Eloquent\Scheduling;

use App\Domain\Interfaces\Scheduling\EventProcedureRepositoryInterface;
use App\Models\Scheduling\EventProcedure;

class EventProcedureRepository implements EventProcedureRepositoryInterface
{
    public function save(EventProcedure $entity): bool
    {
        return $entity->save();
    }

    public function getById(int $id): ?EventProcedure
    {
        return EventProcedure::find($id);
    }

    public function list(): array
    {
        return EventProcedure::orderBy('id')->get()->toArray();
    }

    public function update(EventProcedure $entity): bool
    {
        return $entity->update();
    }

    public function delete(EventProcedure $entity): bool
    {
        return $entity->delete();
    }
}
