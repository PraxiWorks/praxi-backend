<?php

namespace App\Domain\Interfaces\Core\Permission;

use App\Models\Core\Permission\Permission;
use Illuminate\Database\Eloquent\Collection;

interface PermissionRepositoryInterface
{
    public function save(Permission $entity): bool;
    public function getById(int $id): ?Permission;
    public function list(int $companyId): array;
    public function update(Permission $entity): bool;
    public function delete(Permission $entity): bool;
    public function getByName(string $name): ?Permission;
    public function getPermissionByAction(string $action): ?Collection;
}
