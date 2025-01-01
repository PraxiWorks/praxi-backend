<?php

namespace App\Infrastructure\Eloquent\Settings\Company;

use App\Domain\Interfaces\Settings\Company\CompanyPlanRepositoryInterface;
use App\Models\Settings\Company\CompanyPlan;

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
