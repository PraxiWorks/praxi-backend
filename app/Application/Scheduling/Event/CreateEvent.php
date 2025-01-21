<?php

namespace App\Application\Scheduling\Event;

use App\Application\Scheduling\Event\DTO\CreateEventRequestDTO;
use App\Domain\Exceptions\Scheduling\Event\EventException;
use App\Domain\Interfaces\Scheduling\EventRepositoryInterface;
use App\Domain\Interfaces\Scheduling\EventValidatorRepositoryInterface;
use App\Models\Scheduling\Event;

class CreateEvent
{
    public function __construct(
        private EventRepositoryInterface $eventRepositoryInterface,
        private EventValidatorRepositoryInterface $eventValidatorRepositoryInterface
    ) {}

    public function execute(CreateEventRequestDTO $input): bool
    {
        $this->eventValidatorRepositoryInterface->validate($input);

        $event = Event::new(
            $input->getCompanyId(),
            $input->getEventType(),
            $input->getClientId(),
            $input->getProfessionalId(),
            $input->getEventProcedureId(),
            $input->getEventStatusId(),
            $input->getEventColorId(),
            $input->getObservation(),
            $input->getSelectedDayIndex(),
            $input->getDate(),
            $input->getStartEvent(),
            $input->getEndEvent(),
            $input->getEventRecurrenceId()
        );

        if (!$this->eventRepositoryInterface->save($event)) {
            throw new EventException('Erro ao salvar evento', 500);
        }

        return true;
    }
}
