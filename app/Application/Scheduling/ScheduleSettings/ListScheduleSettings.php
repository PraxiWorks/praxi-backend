<?php

namespace App\Application\Scheduling\ScheduleSettings;

use App\Domain\Interfaces\Scheduling\ScheduleSettingsRepositoryInterface;

class ListScheduleSettings
{
    private ScheduleSettingsRepositoryInterface $scheduleSettingsRepositoryInterface;

    public function __construct(ScheduleSettingsRepositoryInterface $scheduleSettingsRepositoryInterface)
    {
        $this->scheduleSettingsRepositoryInterface = $scheduleSettingsRepositoryInterface;
    }

    public function execute() : array
    {
        $response = $this->scheduleSettingsRepositoryInterface->list();

        return $response;
    }
}
