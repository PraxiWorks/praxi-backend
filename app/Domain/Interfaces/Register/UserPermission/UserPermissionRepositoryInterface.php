<?php

namespace App\Domain\Interfaces\Register\UserPermission;

use App\Models\Register\UserPermission\UserPermission;

interface UserPermissionRepositoryInterface
{
    public function save(UserPermission $entity): bool;
    public function getById(int $id): ?UserPermission;
    public function list(int $companyId): array;
    public function update(UserPermission $entity): bool;
    public function delete(UserPermission $entity): bool;
    public function deleteByUserIdAndPermissionIds(int $userId, array $permissionIds): bool;
    public function getByUserIdAndPermissionId(int $userId, int $permissionId): ?UserPermission;
    public function getByUserId(int $userId): array;
    public function getPermissionIdsByUserId(int $userId): array;
}
