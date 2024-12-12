<?php

namespace App\Models\Scheduling;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScheduleSettings extends Model
{
    use HasFactory;
    protected $table = 'schedule_settings';
    protected $primaryKey = 'id';

    protected $fillable = ['company_id', 'day_of_week', 'start_time', 'end_time', 'is_working_day'];

    public static function new(int $companyId, string $dayOfWeek, string $startTime, string $endTime, bool $isWorking): ScheduleSettings
    {
        return new self(
            [
                'company_id' => $companyId,
                'day_of_week' => $dayOfWeek,
                'start_time' => $startTime,
                'end_time' => $endTime,
                'is_working_day' => $isWorking
            ]
        );
    }
}
