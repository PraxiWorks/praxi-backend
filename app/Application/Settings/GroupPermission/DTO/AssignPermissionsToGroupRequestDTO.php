<?php

namespace App\Application\Settings\GroupPermission\DTO;

class AssignPermissionsToGroupRequestDTO
{
    public function __construct(
        private int $groupId,
        private array $permissions
    ) {}

    public function getGroupId(): int
    {
        return $this->groupId;
    }

    public function getPermissions(): array
    {
        return $this->permissions;
    }
}
