<?php

namespace App\Application\Settings\EventProcedure\DTO;

class UpdateEventProcedureRequestDTO
{

    public function __construct(
        private int $id,
        private int $companyId,
        private string $name,
        private bool $status
    ) {}

    public function getId(): int
    {
        return $this->id;
    }

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
