<?php

namespace App\Domain\Interfaces\Core\Permission;

use App\Models\Core\Permission\Permission;

interface PermissionRepositoryInterface
{
    public function save(Permission $entity): bool;
    public function getById(int $id): ?Permission;
    public function list(int $companyId): array;
    public function update(Permission $entity): bool;
    public function delete(Permission $entity): bool;
    public function getByName(string $name): ?Permission;
}
