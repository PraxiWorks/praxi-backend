<?php

namespace App\Application\Scheduling\ScheduleSettings;

use App\Domain\Interfaces\Scheduling\ScheduleSettingsRepositoryInterface;

class ListScheduleSettings
{

    public function __construct(private ScheduleSettingsRepositoryInterface $scheduleSettingsRepositoryInterface) {}

    public function execute(): array
    {
        $response = $this->scheduleSettingsRepositoryInterface->list();

        return $response;
    }
}
