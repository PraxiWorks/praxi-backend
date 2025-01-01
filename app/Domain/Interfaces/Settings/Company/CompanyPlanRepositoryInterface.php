<?php

namespace App\Domain\Interfaces\Settings\Company;

use App\Models\Settings\Company\CompanyPlan;

interface CompanyPlanRepositoryInterface
{
    public function save(CompanyPlan $entity): bool;
    public function getById(int $id): ?CompanyPlan;
    public function list(): array;
    public function update(CompanyPlan $entity): bool;
}
