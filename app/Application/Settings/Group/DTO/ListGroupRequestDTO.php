<?php

namespace App\Application\Settings\Group\DTO;

class ListGroupRequestDTO
{

    public function __construct(
        private int $companyId,
        private bool $status,
    ) {}

    public function getCompanyId(): int
    {
        return $this->companyId;
    }

    public function getStatus(): bool
    {
        return $this->status;
    }
}
