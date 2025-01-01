<?php

namespace App\Infrastructure\Eloquent\Register\User;

use App\Domain\Interfaces\Register\User\UserPermissionRepositoryInterface;
use App\Models\Register\User\UserPermission;

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

    public function getByUserIdAndPermissionId(int $userId, int $permissionId): ?UserPermission
    {
        return UserPermission::where('user_id', $userId)
            ->where('permission_id', $permissionId)
            ->first();
    }
}
