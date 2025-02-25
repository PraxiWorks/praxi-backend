<?php

namespace App\Domain\Interfaces\Scheduling;

use App\Models\Scheduling\ScheduleSettings;

interface ScheduleSettingsRepositoryInterface
{
    public function save(ScheduleSettings $entity): bool;
    public function getById(int $id): ?ScheduleSettings;
    public function list(int $companyId): array;
    public function update(ScheduleSettings $entity): bool;
    public function getScheduleSettingsByCompanyId(int $companyId): ?ScheduleSettings;
}
