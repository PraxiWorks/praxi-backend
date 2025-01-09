<?php

namespace App\Services\Scheduling\Event;

use App\Domain\Exceptions\Register\Client\ClientNotFoundException;
use App\Domain\Exceptions\Register\User\UserNotFoundException;
use App\Domain\Exceptions\Scheduling\Event\EventColorNotFoundException;
use App\Domain\Exceptions\Scheduling\Event\EventRecurrenceNotFoundException;
use App\Domain\Exceptions\Scheduling\Event\EventStatusNotFoundException;
use App\Domain\Exceptions\Scheduling\Event\EventTypeNotFoundException;
use App\Domain\Exceptions\Settings\EventProcedure\EventProcedureNotFoundException;
use App\Domain\Interfaces\Register\Client\ClientRepositoryInterface;
use App\Domain\Interfaces\Register\User\UserRepositoryInterface;
use App\Domain\Interfaces\Scheduling\EventColorRepositoryInterface;
use App\Domain\Interfaces\Scheduling\EventStatusRepositoryInterface;
use App\Domain\Interfaces\Scheduling\EventTypeRepositoryInterface;
use App\Domain\Interfaces\Scheduling\EventValidatorRepositoryInterface;
use App\Domain\Interfaces\Settings\EventProcedure\EventProcedureRepositoryInterface;
use App\Infrastructure\Eloquent\Scheduling\EventRecurrenceRepository;

class EventValidator implements EventValidatorRepositoryInterface
{
    public function __construct(
        private EventTypeRepositoryInterface $eventTypeRepository,
        private ClientRepositoryInterface $clientRepository,
        private UserRepositoryInterface $userRepository,
        private EventProcedureRepositoryInterface $eventProcedureRepository,
        private EventStatusRepositoryInterface $eventStatusRepository,
        private EventColorRepositoryInterface $eventColorRepository,
        private EventRecurrenceRepository $eventRecurrenceRepository
    ) {}

    public function validate($input): void
    {
        $this->validateEventType($input->getEventTypeId());
        $this->validateClient($input->getClientId());
        $this->validateProfessional($input->getProfessionalId());
        $this->validateEventProcedure($input->getEventProcedureId());
        $this->validateEventStatus($input->getEventStatusId());
        $this->validateEventColor($input->getEventColorId());
        $this->validateEventRecurrence($input->getEventRecurrenceId());
    }

    private function validateEventType(int $eventTypeId): void
    {
        $eventType = $this->eventTypeRepository->getById($eventTypeId);

        if (empty($eventType)) {
            throw new EventTypeNotFoundException('Tipo não encontrado', 404);
        }
    }

    private function validateClient(int $clientId): void
    {
        $client = $this->clientRepository->getById($clientId);

        if (empty($client)) {
            throw new ClientNotFoundException('Cliente não encontrado', 404);
        }
    }

    private function validateProfessional(int $professionalId): void
    {
        $professional = $this->userRepository->getById($professionalId);

        if (empty($professional)) {
            throw new UserNotFoundException('Profissional não encontrado', 404);
        }
    }

    private function validateEventProcedure(int $eventProcedureId): void
    {
        $eventProcedure = $this->eventProcedureRepository->getById($eventProcedureId);

        if (empty($eventProcedure)) {
            throw new EventProcedureNotFoundException('Procedimento não encontrado', 404);
        }
    }

    private function validateEventStatus(int $eventStatusId): void
    {
        $eventStatus = $this->eventStatusRepository->getById($eventStatusId);

        if (empty($eventStatus)) {
            throw new EventStatusNotFoundException('Status do evento não encontrado', 404);
        }
    }

    private function validateEventColor(int $eventColorId): void
    {
        $eventColor = $this->eventColorRepository->getById($eventColorId);

        if (empty($eventColor)) {
            throw new EventColorNotFoundException('Cor do evento não encontrada', 404);
        }
    }

    private function validateEventRecurrence(int $eventRecurrenceId): void
    {
        $eventRecurrence = $this->eventRecurrenceRepository->getById($eventRecurrenceId);

        if (empty($eventRecurrence)) {
            throw new EventRecurrenceNotFoundException('Recorrência do evento não encontrada', 404);
        }
    }
}
