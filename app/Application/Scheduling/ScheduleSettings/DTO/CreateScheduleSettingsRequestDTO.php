<?php

namespace App\Application\Scheduling\ScheduleSettings\DTO;

class CreateScheduleSettingsRequestDTO
{

    public function __construct(
        private int $companyId,
        private array $workSchedule
    ) {}

    public function getCompanyId(): int
    {
        return $this->companyId;
    }

    public function getWorkSchedule(): array
    {
        return $this->workSchedule;
    }
}
