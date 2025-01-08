<?php

namespace App\Application\Scheduling\Event;

use App\Application\Scheduling\Event\DTO\UpdateEventRequestDTO;
use App\Domain\Exceptions\Scheduling\Event\EventException;
use App\Domain\Exceptions\Scheduling\Event\EventNotFoundException;
use App\Domain\Interfaces\Scheduling\EventRepositoryInterface;
use App\Domain\Interfaces\Scheduling\EventValidatorRepositoryInterface;

class UpdateEvent
{
    public function __construct(
        private EventRepositoryInterface $eventRepositoryInterface,
        private EventValidatorRepositoryInterface $eventValidatorRepositoryInterface,
    ) {}

    public function execute(UpdateEventRequestDTO $input): bool
    {
        $this->eventValidatorRepositoryInterface->validate($input);

        $event = $this->eventRepositoryInterface->getById($input->getId());
        if (empty($event)) {
            throw new EventNotFoundException('Evento não encontrado', 404);
        }

        $event->event_type_id = $input->getEventTypeId();
        $event->client_id = $input->getClientId();
        $event->professional_id = $input->getProfessionalId();
        $event->event_procedure_id = $input->getEventProcedureId();
        $event->event_status_id = $input->getEventStatusId();
        $event->event_color_id = $input->getEventColorId();
        $event->observation = $input->getObservation();
        $event->day = $input->getDay();
        $event->start_event = $input->getStartEvent();
        $event->end_event = $input->getEndEvent();
        $event->event_recurrence_id = $input->getEventRecurrenceId();

        if (!$this->eventRepositoryInterface->update($event)) {
            throw new EventException('Erro ao atualizar o evento', 500);
        }

        return true;
    }
}
