<?php

namespace App\Infrastructure\Eloquent\Settings\Group;

use App\Domain\Interfaces\Settings\Group\GroupPermissionRepositoryInterface;
use App\Models\Core\Permission\GroupPermission;

class GroupPermissionRepository implements GroupPermissionRepositoryInterface
{
    public function save(GroupPermission $entity): bool
    {
        return $entity->save();
    }

    public function getById(int $id): ?GroupPermission
    {
        return GroupPermission::find($id);
    }

    public function list(int $companyId): array
    {
        return GroupPermission::get()->toArray();
    }

    public function update(GroupPermission $entity): bool
    {
        return $entity->update();
    }

    public function delete(GroupPermission $entity): bool
    {
        return $entity->delete();
    }

    public function getByGroupIdAndPermissionId(int $groupId, int $permissionId): ?GroupPermission
    {
        return GroupPermission::where('group_id', $groupId)
            ->where('permission_id', $permissionId)
            ->first();
    }
}
