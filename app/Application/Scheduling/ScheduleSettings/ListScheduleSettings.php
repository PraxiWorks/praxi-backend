<?php

namespace App\Application\Scheduling\ScheduleSettings;

use App\Application\DTO\IdRequestDTO;
use App\Domain\Interfaces\Scheduling\ScheduleSettingsRepositoryInterface;

class ListScheduleSettings
{

    public function __construct(private ScheduleSettingsRepositoryInterface $scheduleSettingsRepositoryInterface) {}

    public function execute(IdRequestDTO $input): array
    {
        $response = $this->scheduleSettingsRepositoryInterface->list($input->getId());

        return $response;
    }
}
