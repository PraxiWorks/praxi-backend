<?php

namespace App\Infrastructure\Eloquent\Scheduling;

use App\Domain\Interfaces\Scheduling\ScheduleSettingsRepositoryInterface;
use App\Models\Scheduling\ScheduleSettings;

class ScheduleSettingsRepository implements ScheduleSettingsRepositoryInterface
{
    public function save(ScheduleSettings $entity): bool
    {
        return $entity->save();
    }

    public function getById(int $id): ?ScheduleSettings
    {
        return ScheduleSettings::find($id);
    }

    public function list(int $companyId): array
    {
        return ScheduleSettings::where('company_id', $companyId)->orderBy('id')->get()->toArray();
    }

    public function update(ScheduleSettings $entity): bool
    {
        return $entity->update();
    }

    public function getScheduleSettingsByCompanyId(int $companyId): ?ScheduleSettings
    {
        return ScheduleSettings::where('company_id', $companyId)->first();
    }
}
