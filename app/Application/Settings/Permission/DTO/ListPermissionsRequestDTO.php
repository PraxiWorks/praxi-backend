<?php

namespace App\Application\Settings\Permission\DTO;

class ListPermissionsRequestDTO
{
    public function __construct(
        private int $companyId,
        private array $permissions
    ) {}

    public function getCompanyId(): int
    {
        return $this->companyId;
    }

    public function getPermissions(): array
    {
        return $this->permissions;
    }
}
