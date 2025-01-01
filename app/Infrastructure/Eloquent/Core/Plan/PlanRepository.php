<?php

namespace App\Infrastructure\Eloquent\Core\Plan;

use App\Domain\Interfaces\Core\Plan\PlanRepositoryInterface;
use App\Models\Core\Plan\Plan;

class PlanRepository implements PlanRepositoryInterface
{
    public function save(Plan $entity): bool
    {
        return $entity->save();
    }

    public function getById(int $id): ?Plan
    {
        return Plan::find($id);
    }

    public function list(int $companyId): array
    {
        return Plan::where('company_id', $companyId)->get()->toArray();
    }

    public function update(Plan $entity): bool
    {
        return $entity->save();
    }

    public function delete(Plan $entity): bool
    {
        return $entity->delete();
    }
}
