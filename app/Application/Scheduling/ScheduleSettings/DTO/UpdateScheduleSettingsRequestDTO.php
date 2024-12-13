<?php

namespace App\Application\Scheduling\ScheduleSettings\DTO;

class UpdateScheduleSettingsRequestDTO
{
    private int $id;
    private string $dayOfWeek;
    private string $startTime;
    private string $endTime;
    private bool $isWorkingDay;

    public function __construct(int $id, string $dayOfWeek, string $startTime, string $endTime, bool $isWorkingDay)
    {
        $this->id = $id;
        $this->dayOfWeek = $dayOfWeek;
        $this->startTime = $startTime;
        $this->endTime = $endTime;
        $this->isWorkingDay = $isWorkingDay;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getDayOfWeek(): string
    {
        return $this->dayOfWeek;
    }

    public function getStartTime(): string
    {
        return $this->startTime;
    }

    public function getEndTime(): string
    {
        return $this->endTime;
    }

    public function getIsWorkingDay(): bool
    {
        return $this->isWorkingDay;
    }
}
