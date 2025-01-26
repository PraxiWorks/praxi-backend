<?php

namespace App\Infrastructure\Eloquent\Register\UserPermission;

use App\Domain\Interfaces\Register\UserPermission\UserPermissionRepositoryInterface;
use App\Models\Register\UserPermission\UserPermission;

class UserPermissionRepository implements UserPermissionRepositoryInterface
{
    public function save(UserPermission $entity): bool
    {
        return $entity->save();
    }

    public function getById(int $id): ?UserPermission
    {
        return UserPermission::find($id);
    }

    public function list(int $companyId): array
    {
        return UserPermission::get()->toArray();
    }

    public function update(UserPermission $entity): bool
    {
        return $entity->update();
    }

    public function delete(UserPermission $entity): bool
    {
        return $entity->delete();
    }

    public function deleteByUserIdAndPermissionIds(int $userId, array $permissionIds): bool
    {
        return UserPermission::where('user_id', $userId)
            ->whereIn('permission_id', $permissionIds)
            ->delete();
    }

    public function getByUserIdAndPermissionId(int $userId, int $permissionId): ?UserPermission
    {
        return UserPermission::where('user_id', $userId)
            ->where('permission_id', $permissionId)
            ->first();
    }

    public function getByUserId(int $userId): array
    {
        return UserPermission::where('user_id', $userId)->get()->toArray();
    }

    public function getPermissionIdsByUserId(int $userId): array
    {
        return UserPermission::where('user_id', $userId)
            ->pluck('permission_id')
            ->toArray();
    }
}
