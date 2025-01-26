<?php

namespace App\Application\Register\User\DTO;

class ListUserRequestDTO
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
