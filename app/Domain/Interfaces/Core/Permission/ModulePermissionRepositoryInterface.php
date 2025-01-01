<?php

namespace App\Domain\Interfaces\Core\Permission;

use App\Models\Core\Permission\ModulePermission;
use Illuminate\Database\Eloquent\Collection;

interface ModulePermissionRepositoryInterface
{
    public function save(ModulePermission $entity): bool;
    public function getById(int $id): ?ModulePermission;
    public function list(int $moduleId): array;
    public function update(ModulePermission $entity): bool;
    public function delete(ModulePermission $entity): bool;
    public function getPermissionsByList(array $moduleIds): Collection;
}
