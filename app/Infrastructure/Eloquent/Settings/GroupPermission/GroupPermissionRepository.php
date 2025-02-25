<?php

namespace App\Infrastructure\Eloquent\Settings\GroupPermission;

use App\Domain\Interfaces\Settings\GroupPermission\GroupPermissionRepositoryInterface;
use App\Models\Settings\GroupPermission\GroupPermission;

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

    public function delete(int $id): bool
    {
        return GroupPermission::where('id', $id)->delete();
    }

    public function deleteByGroupIdAndPermissionIds(int $groupId, array $permissionIds): bool
    {
        return GroupPermission::where('group_id', $groupId)
            ->whereIn('permission_id', $permissionIds)
            ->delete();
    }

    public function getByGroupIdAndPermissionId(int $groupId, int $permissionId): ?GroupPermission
    {
        return GroupPermission::where('group_id', $groupId)
            ->where('permission_id', $permissionId)
            ->first();
    }

    public function getByGroupId(int $groupId): array
    {
        return GroupPermission::where('group_id', $groupId)->get()->toArray();
    }

    public function getPermissionIdsByGroupId(int $groupId): array
    {
        return GroupPermission::where('group_id', $groupId)
            ->pluck('permission_id')
            ->toArray();
    }
}
