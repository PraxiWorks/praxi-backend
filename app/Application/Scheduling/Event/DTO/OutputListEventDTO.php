<?php

namespace App\Application\Scheduling\Event\DTO;

class OutputListEventDTO
{
    public function __construct(
        private int $id,
        private string $eventType,
        private string $clientName,
        private string $professionalName,
        private string $eventProcedureName,
        private string $eventStatusName,
        private string $eventColorName,
        private ?string $observation,
        private int $selectedDayIndex,
        private string $date,
        private string $startTime,
        private string $endTime,
        private string $eventRecurrenceName
    ) {}

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'type' => $this->eventType,
            'client' => $this->clientName,
            'professional' => $this->professionalName,
            'procedure' => $this->eventProcedureName,
            'status' => $this->eventStatusName,
            'color' => $this->eventColorName,
            'observations' => $this->observation,
            'selected_day_index' => $this->selectedDayIndex,
            'date' => $this->date,
            'start_time' => $this->startTime,
            'end_time' => $this->endTime,
            'recurrence' => $this->eventRecurrenceName,
        ];
    }
}
