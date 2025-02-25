<?php

namespace App\Application\Settings\GroupPermission;

use App\Application\DTO\IdRequestDTO;
use App\Domain\Interfaces\Settings\GroupPermission\GroupPermissionRepositoryInterface;

class GetPermissionsGroup
{
    public function __construct(
        private GroupPermissionRepositoryInterface $groupPermissionRepositoryInterface
    ) {}

    public function execute(IdRequestDTO $input): array
    {
        $groupPermissions = $this->groupPermissionRepositoryInterface->getByGroupId($input->getId());

        $permissionIds = [];
        if (!empty($groupPermissions)) {
            foreach ($groupPermissions as $groupPermission) {
                $permissionIds[] = $groupPermission['permission_id'];
            }
        }

        return $permissionIds;
    }
}
