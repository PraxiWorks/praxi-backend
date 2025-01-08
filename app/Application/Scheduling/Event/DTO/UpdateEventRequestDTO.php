<?php

namespace App\Application\Scheduling\Event\DTO;

use DateTime;

class UpdateEventRequestDTO
{

    public function __construct(
        private int $id,
        private int $companyId,
        private int $eventTypeId,
        private int $clientId,
        private int $professionalId,
        private int $eventProcedureId,
        private int $eventStatusId,
        private int $eventColorId,
        private ?string $observation,
        private string $day,
        private string $startEvent,
        private string $endEvent,
        private int $eventRecurrenceId
    ) {}

    public function getId(): int
    {
        return $this->id;
    }

    public function getCompanyId(): int
    {
        return $this->companyId;
    }

    public function getEventTypeId(): int
    {
        return $this->eventTypeId;
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

    public function getDay(): string
    {
        return $this->day;
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
