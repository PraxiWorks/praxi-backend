<?php

namespace App\Domain\Interfaces\Core\Plan;

use App\Models\Core\Plan\Plan;

interface PlanRepositoryInterface
{
    public function save(Plan $entity): bool;
    public function getById(int $id): ?Plan;
    public function list(int $companyId): array;
    public function update(Plan $entity): bool;
    public function delete(Plan $entity): bool;
}
