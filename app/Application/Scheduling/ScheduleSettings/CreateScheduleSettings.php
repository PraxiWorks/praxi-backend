<?php

namespace App\Application\Scheduling\ScheduleSettings;

use App\Application\Scheduling\ScheduleSettings\DTO\ScheduleSettingsInputDTO;
use App\Domain\Exceptions\Company\CompanyException;
use App\Domain\Exceptions\Scheduling\ScheduleSettings\ScheduleSettingsException;
use App\Domain\Interfaces\Company\CompanyRepositoryInterface;
use App\Domain\Interfaces\Scheduling\ScheduleSettingsRepositoryInterface;
use App\Models\Scheduling\ScheduleSettings;

class CreateScheduleSettings
{
    private CompanyRepositoryInterface $companyRepositoryInterface;
    private ScheduleSettingsRepositoryInterface $scheduleSettingsRepositoryInterface;

    public function __construct(
        CompanyRepositoryInterface $companyRepositoryInterface,
        ScheduleSettingsRepositoryInterface $scheduleSettingsRepositoryInterface
    ) {
        $this->companyRepositoryInterface = $companyRepositoryInterface;
        $this->scheduleSettingsRepositoryInterface = $scheduleSettingsRepositoryInterface;
    }

    public function execute(ScheduleSettingsInputDTO $input): bool
    {

        $company = $this->companyRepositoryInterface->getCompanyById($input->getCompanyId());
        if (empty($company)) {
            throw new CompanyException('Empresa não encontrada.', 404);
        }

        $scheduleSettings = $this->scheduleSettingsRepositoryInterface->getScheduleSettingsByCompanyId($company->id);
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
                $company->id,
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
