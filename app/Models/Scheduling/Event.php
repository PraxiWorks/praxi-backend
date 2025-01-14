<?php

namespace App\Models\Scheduling;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    protected $table = 'events';
    protected $primaryKey = 'id';

    protected $fillable = [
        'company_id',
        'event_type_id',
        'client_id',
        'professional_id',
        'event_procedure_id',
        'event_status_id',
        'event_color_id',
        'observation',
        'day',
        'start_event',
        'end_event',
        'event_recurrence_id'
    ];

    public static function new(
        int $companyId,
        int $eventTypeId,
        int $clientId,
        int $professionalId,
        int $eventProcedureId,
        int $eventStatusId,
        int $eventColorId,
        ?string $observation,
        string $day,
        string $startEvent,
        string $endEvent,
        int $eventRecurrenceId
    ): Event {
        return new self(
            [
                'company_id' => $companyId,
                'event_type_id' => $eventTypeId,
                'client_id' => $clientId,
                'professional_id' => $professionalId,
                'event_procedure_id' => $eventProcedureId,
                'event_status_id' => $eventStatusId,
                'event_color_id' => $eventColorId,
                'observation' => $observation,
                'day' => $day,
                'start_event' => $startEvent,
                'end_event' => $endEvent,
                'event_recurrence_id' => $eventRecurrenceId
            ]
        );
    }
}
