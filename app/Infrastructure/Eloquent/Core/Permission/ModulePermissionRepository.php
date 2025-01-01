<?php

namespace App\Infrastructure\Eloquent\Core\Permission;

use App\Domain\Interfaces\Core\Permission\ModulePermissionRepositoryInterface;
use App\Models\Core\Permission\ModulePermission;
use Illuminate\Database\Eloquent\Collection;

class ModulePermissionRepository implements ModulePermissionRepositoryInterface
{
    public function save(ModulePermission $entity): bool
    {
        return $entity->save();
    }

    public function getById(int $id): ?ModulePermission
    {
        return ModulePermission::find($id);
    }

    public function list(int $moduleId): array
    {
        return ModulePermission::get()->toArray();
    }

    public function update(ModulePermission $entity): bool
    {
        return $entity->update();
    }

    public function delete(ModulePermission $entity): bool
    {
        return $entity->delete();
    }

    public function getPermissionsByList(array $moduleIds): Collection
    {
        return ModulePermission::whereIn('module_id', $moduleIds)->get();
    }
}
