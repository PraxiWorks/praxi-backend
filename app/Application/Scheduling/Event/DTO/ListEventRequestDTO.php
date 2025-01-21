<?php

namespace App\Application\Scheduling\Event\DTO;

class ListEventRequestDTO
{

    public function __construct(
        private int $companyId,
        private ?string $startDay,
        private ?string $endDay
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
}
