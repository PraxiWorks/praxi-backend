<?php

namespace App\Application\Scheduling\Event\DTO;

class ListEventRequestDTO
{

    public function __construct(
        private int $companyId,
        private ?string $startDay,
        private ?string $endDay,
        private ?int $professionalId,
        private ?int $clientId,
        private ?int $procedureId
    ) {}

    public function getCompanyId(): ?int
    {
        return $this->companyId;
    }

    public function getStartDay(): ?string
    {
        return $this->startDay;
    }

    public function getEndDay(): ?string
    {
        return $this->endDay;
    }

    public function getProfessionalId(): ?int
    {
        return $this->professionalId;
    }

    public function getClientId(): ?int
    {
        return $this->clientId;
    }

    public function getProcedureId(): ?int
    {
        return $this->procedureId;
    }
}
