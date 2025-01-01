<?php

namespace App\Domain\Interfaces\Register\User;

use App\Models\Register\User\UserPermission;

interface UserPermissionRepositoryInterface
{
    public function save(UserPermission $entity): bool;
    public function getById(int $id): ?UserPermission;
    public function list(int $companyId): array;
    public function update(UserPermission $entity): bool;
    public function delete(UserPermission $entity): bool;
    public function getByUserIdAndPermissionId(int $userId, int $permissionId): ?UserPermission;
}
