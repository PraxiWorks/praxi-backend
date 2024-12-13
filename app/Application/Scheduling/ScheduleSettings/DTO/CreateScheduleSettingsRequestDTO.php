<?php

namespace App\Application\Scheduling\ScheduleSettings\DTO;

class CreateScheduleSettingsRequestDTO
{
    private int $companyId;
    private array $workSchedule;

    public function __construct(int $companyId, array $workSchedule)
    {
        $this->companyId = $companyId;
        $this->workSchedule = $workSchedule;
    }

    public function getCompanyId(): int
    {
        return $this->companyId;
    }

    public function getWorkSchedule(): array
    {
        return $this->workSchedule;
    }
}
