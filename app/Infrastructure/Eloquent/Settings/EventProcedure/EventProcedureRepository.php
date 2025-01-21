<?php

namespace App\Infrastructure\Eloquent\Settings\EventProcedure;

use App\Domain\Interfaces\Settings\EventProcedure\EventProcedureRepositoryInterface;
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

    public function findByNameAndCompanyId(int $company_id, string $name): ?EventProcedure
    {
        return EventProcedure::where('company_id', $company_id)->where('name', $name)->first();
    }
}
