<?php

namespace App\Infrastructure\Eloquent\Core\Permission;

use App\Domain\Interfaces\Core\Permission\PermissionRepositoryInterface;
use App\Models\Core\Permission\Permission;
use Illuminate\Database\Eloquent\Collection;

class PermissionRepository implements PermissionRepositoryInterface
{
    public function save(Permission $entity): bool
    {
        return $entity->save();
    }

    public function getById(int $id): ?Permission
    {
        return Permission::find($id);
    }

    public function list(int $companyId): array
    {
        return Permission::get()->toArray();
    }

    public function update(Permission $entity): bool
    {
        return $entity->update();
    }

    public function delete(Permission $entity): bool
    {
        return $entity->delete();
    }

    public function getByName(string $name): ?Permission
    {
        return Permission::where('name', $name)->first();
    }

    public function getPermissionByAction(string $action): ?Collection
    {
        return Permission::where('name', 'like', '%' . $action . '%')->get();
    }
}
