<?php

namespace App\Domain\Interfaces\Core\Company;

use App\Models\Core\Company\CompanyPlan;

interface CompanyPlanRepositoryInterface
{
    public function save(CompanyPlan $entity): bool;
    public function getById(int $id): ?CompanyPlan;
    public function list(): array;
    public function update(CompanyPlan $entity): bool;
    public function getByCompanyId(int $id): ?CompanyPlan;
}
