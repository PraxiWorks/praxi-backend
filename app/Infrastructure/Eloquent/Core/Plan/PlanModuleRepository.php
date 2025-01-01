<?php

namespace App\Infrastructure\Eloquent\Core\Plan;

use App\Domain\Interfaces\Core\Plan\PlanModuleRepositoryInterface;
use App\Models\Core\Plan\PlanModule;
use Illuminate\Database\Eloquent\Collection;

class PlanModuleRepository implements PlanModuleRepositoryInterface
{
    public function save(PlanModule $entity): bool
    {
        return $entity->save();
    }

    public function getById(int $id): ?PlanModule
    {
        return PlanModule::find($id);
    }

    public function list(int $companyId): array
    {
        return PlanModule::where('company_id', $companyId)->get()->toArray();
    }

    public function update(PlanModule $entity): bool
    {
        return $entity->save();
    }

    public function delete(PlanModule $entity): bool
    {
        return $entity->delete();
    }

    public function getByPlanId(int $planId): Collection
    {
        return PlanModule::where('plan_id', $planId)->get();
    }
}
