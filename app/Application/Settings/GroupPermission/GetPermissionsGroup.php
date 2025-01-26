<?php

namespace App\Application\Settings\GroupPermission;

use App\Application\DTO\IdRequestDTO;
use App\Infrastructure\Eloquent\Register\User\UserRepository;
use App\Infrastructure\Eloquent\Settings\GroupPermission\GroupPermissionRepository;

class GetPermissionsGroup
{
    public function __construct(
        private UserRepository $userRepositoryInterface,
        private GroupPermissionRepository $groupPermissionRepositoryInterface
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
