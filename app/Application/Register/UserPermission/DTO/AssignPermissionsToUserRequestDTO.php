<?php

namespace App\Application\Register\UserPermission\DTO;

class AssignPermissionsToUserRequestDTO
{
    public function __construct(
        private int $userId,
        private array $permissions
    ) {}

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getPermissions(): array
    {
        return $this->permissions;
    }
}
