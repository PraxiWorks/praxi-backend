<?php

namespace App\Infrastructure\Eloquent\Core\Company;

use App\Domain\Interfaces\Core\Company\CompanyPlanRepositoryInterface;
use App\Models\Core\Company\CompanyPlan;

class CompanyPlanRepository implements CompanyPlanRepositoryInterface
{
    public function save(CompanyPlan $entity): bool
    {
        return $entity->save();
    }

    public function getById(int $id): ?CompanyPlan
    {
        return CompanyPlan::find($id);
    }

    public function list(): array
    {
        return CompanyPlan::get()->toArray();
    }

    public function update(CompanyPlan $entity): bool
    {
        return $entity->update();
    }
}
