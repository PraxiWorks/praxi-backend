<?php

namespace App\Domain\Interfaces\Core\Plan;

use App\Models\Core\Plan\PlanModule;
use Illuminate\Database\Eloquent\Collection;

interface PlanModuleRepositoryInterface
{
    public function save(PlanModule $entity): bool;
    public function getById(int $id): ?PlanModule;
    public function list(int $companyId): array;
    public function update(PlanModule $entity): bool;
    public function delete(PlanModule $entity): bool;
    public function getByPlanId(int $planId): Collection;
}
