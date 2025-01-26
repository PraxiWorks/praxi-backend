<?php

namespace App\Application\Scheduling\ScheduleSettings;

use App\Application\Scheduling\ScheduleSettings\DTO\UpdateScheduleSettingsRequestDTO;
use App\Domain\Exceptions\Scheduling\ScheduleSettings\ScheduleSettingsException;
use App\Domain\Interfaces\Scheduling\ScheduleSettingsRepositoryInterface;

class UpdateScheduleSettings
{

    public function __construct(private ScheduleSettingsRepositoryInterface $scheduleSettingsRepositoryInterface) {}

    public function execute(UpdateScheduleSettingsRequestDTO $input): void
    {
        $this->validateInput($input);

        $scheduleSettings = $this->scheduleSettingsRepositoryInterface->getById($input->getId());

        if (empty($scheduleSettings)) {
            throw new ScheduleSettingsException('Configuração de agenda não encontrada', 404);
        }

        $scheduleSettings->day_of_week = $input->getDayOfWeek();
        $scheduleSettings->start_time = $input->getStartTime();
        $scheduleSettings->end_time = $input->getEndTime();
        $scheduleSettings->is_working_day = $input->getIsWorkingDay();

        if (!$this->scheduleSettingsRepositoryInterface->update($scheduleSettings)) {
            throw new ScheduleSettingsException('Erro ao atualizar configuração de agenda', 500);
        }
    }

    private function validateInput(UpdateScheduleSettingsRequestDTO $input): void
    {
        $errors = [];

        if (empty($input->getDayOfWeek())) {
            $errors[] = 'Dia da semana é obrigatório';
        }

        if (empty($input->getStartTime())) {
            $errors[] = 'Hora de início é obrigatório';
        }

        if (empty($input->getEndTime())) {
            $errors[] = 'Hora de término é obrigatório';
        }

        if (!empty($errors)) {
            throw new ScheduleSettingsException(implode(', ', $errors), 400);
        }
    }
}
