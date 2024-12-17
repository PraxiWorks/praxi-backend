<?php

namespace App\Application\Scheduling\ScheduleSettings;

use App\Application\Scheduling\ScheduleSettings\DTO\CreateScheduleSettingsRequestDTO;
use App\Domain\Exceptions\Scheduling\ScheduleSettings\ScheduleSettingsException;
use App\Domain\Interfaces\Scheduling\ScheduleSettingsRepositoryInterface;
use App\Models\Scheduling\ScheduleSettings;

class CreateScheduleSettings
{
    public function __construct(
        private ScheduleSettingsRepositoryInterface $scheduleSettingsRepositoryInterface
    ) {}

    public function execute(CreateScheduleSettingsRequestDTO $input): bool
    {
        $scheduleSettings = $this->scheduleSettingsRepositoryInterface->getScheduleSettingsByCompanyId($input->getCompanyId());
        if (!empty($scheduleSettings)) {
            throw new ScheduleSettingsException('Já existe uma configuração de agenda cadastrada para esta empresa', 400);
        }

        if (empty($input->getWorkSchedule())) {
            throw new ScheduleSettingsException('É necessário selecionar pelo menos um dia de trabalho.', 400);
        }

        $daysOfWeek = ['dom', 'seg', 'ter', 'qua', 'qui', 'sex', 'sab'];

        foreach ($input->getWorkSchedule() as $workDay) {
            if (!in_array($workDay['day'], $daysOfWeek)) {
                throw new ScheduleSettingsException('Dia de trabalho inválido.', 400);
            }

            $scheduleSettings = ScheduleSettings::new(
                $input->getCompanyId(),
                $workDay['day'],
                $workDay['start_time'],
                $workDay['end_time'],
                $workDay['is_working_day']
            );

            if (!$this->scheduleSettingsRepositoryInterface->save($scheduleSettings)) {
                throw new ScheduleSettingsException('Erro ao salvar configuração de agenda.', 500);
            }
        }

        return true;
    }
}
