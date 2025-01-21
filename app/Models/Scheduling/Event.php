<?php

namespace App\Models\Scheduling;

use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    protected $table = 'events';
    protected $primaryKey = 'id';

    protected $fillable = [
        'company_id',
        'event_type',
        'client_id',
        'professional_id',
        'event_procedure_id',
        'event_status_id',
        'event_color_id',
        'observation',
        'selected_day_index',
        'date',
        'start_event',
        'end_event',
        'event_recurrence_id'
    ];

    public static function new(
        int $companyId,
        string $eventType,
        int $clientId,
        int $professionalId,
        int $eventProcedureId,
        int $eventStatusId,
        int $eventColorId,
        ?string $observation,
        int $selectedDayIndex,
        string $date,
        string $startEvent,
        string $endEvent,
        int $eventRecurrenceId
    ): Event {
        return new self(
            [
                'company_id' => $companyId,
                'event_type' => $eventType,
                'client_id' => $clientId,
                'professional_id' => $professionalId,
                'event_procedure_id' => $eventProcedureId,
                'event_status_id' => $eventStatusId,
                'event_color_id' => $eventColorId,
                'observation' => $observation,
                'selected_day_index' => $selectedDayIndex,
                'date' => $date,
                'start_event' => $startEvent,
                'end_event' => $endEvent,
                'event_recurrence_id' => $eventRecurrenceId
            ]
        );
    }
}
