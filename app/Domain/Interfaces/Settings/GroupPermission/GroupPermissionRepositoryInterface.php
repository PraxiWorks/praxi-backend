<?php

namespace App\Domain\Interfaces\Settings\GroupPermission;

use App\Models\Settings\GroupPermission\GroupPermission;

interface GroupPermissionRepositoryInterface
{
    public function save(GroupPermission $entity): bool;
    public function getById(int $id): ?GroupPermission;
    public function list(int $companyId): array;
    public function update(GroupPermission $entity): bool;
    public function delete(int $id): bool;
    public function deleteByGroupIdAndPermissionIds(int $groupId, array $permissionIds): bool;
    public function getByGroupIdAndPermissionId(int $groupId, int $permissionId): ?GroupPermission;
    public function getByGroupId(int $groupId): array;
    public function getPermissionIdsByGroupId(int $groupId): array;
}
