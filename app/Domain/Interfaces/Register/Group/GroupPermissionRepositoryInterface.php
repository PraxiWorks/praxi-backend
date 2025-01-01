<?php

namespace App\Domain\Interfaces\Register\Group;

use App\Models\Core\Permission\GroupPermission;

interface GroupPermissionRepositoryInterface
{
    public function save(GroupPermission $entity): bool;
    public function getById(int $id): ?GroupPermission;
    public function list(int $companyId): array;
    public function update(GroupPermission $entity): bool;
    public function delete(GroupPermission $entity): bool;
    public function getByGroupIdAndPermissionId(int $groupId, int $permissionId): ?GroupPermission;
}
