<?php

namespace App\Application\Scheduling\Event\DTO;

use DateTime;

class CreateEventRequestDTO
{

    public function __construct(
        private int $companyId,
        private string $eventType,
        private int $clientId,
        private int $professionalId,
        private int $eventProcedureId,
        private int $eventStatusId,
        private int $eventColorId,
        private ?string $observation,
        private int $selectedDayIndex,
        private string $date,
        private string $startEvent,
        private string $endEvent,
        private int $eventRecurrenceId
    ) {}

    public function getCompanyId(): int
    {
        return $this->companyId;
    }

    public function getEventType(): string
    {
        return $this->eventType;
    }

    public function getClientId(): int
    {
        return $this->clientId;
    }

    public function getProfessionalId(): int
    {
        return $this->professionalId;
    }

    public function getEventProcedureId(): int
    {
        return $this->eventProcedureId;
    }

    public function getEventStatusId(): int
    {
        return $this->eventStatusId;
    }

    public function getEventColorId(): int
    {
        return $this->eventColorId;
    }

    public function getObservation(): ?string
    {
        return $this->observation;
    }

    public function getSelectedDayIndex(): int
    {
        return $this->selectedDayIndex;
    }

    public function getDate(): string
    {
        return $this->date;
    }

    public function getStartEvent(): string
    {
        return $this->startEvent;
    }

    public function getEndEvent(): string
    {
        return $this->endEvent;
    }

    public function getEventRecurrenceId(): int
    {
        return $this->eventRecurrenceId;
    }
}
