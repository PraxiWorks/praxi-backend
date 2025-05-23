<?php

namespace App\Application\Settings\EventProcedure\DTO;

class CreateEventProcedureRequestDTO
{

    public function __construct(
        private int $companyId,
        private string $name,
        private bool $status
    ) {}

    public function getCompanyId(): int
    {
        return $this->companyId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getStatus(): bool
    {
        return $this->status;
    }
}
