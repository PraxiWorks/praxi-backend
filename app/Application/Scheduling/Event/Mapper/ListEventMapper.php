<?php

namespace App\Application\Scheduling\Event\Mapper;

use App\Application\DTO\OutputArrayDTO;
use App\Application\Scheduling\Event\DTO\OutputListEventDTO;
use App\Domain\Interfaces\Register\Client\ClientRepositoryInterface;
use App\Domain\Interfaces\Register\User\UserRepositoryInterface;
use App\Domain\Interfaces\Scheduling\EventColorRepositoryInterface;
use App\Domain\Interfaces\Scheduling\EventRecurrenceRepositoryInterface;
use App\Domain\Interfaces\Scheduling\EventStatusRepositoryInterface;
use App\Domain\Interfaces\Settings\EventProcedure\EventProcedureRepositoryInterface;

class ListEventMapper
{

    public function __construct(
        private ClientRepositoryInterface $clientRepositoryInterface,
        private UserRepositoryInterface $userRepositoryInterface,
        private EventProcedureRepositoryInterface $eventProcedureRepositoryInterface,
        private EventStatusRepositoryInterface $eventStatusRepositoryInterface,
        private EventColorRepositoryInterface $eventColorRepositoryInterface,
        private EventRecurrenceRepositoryInterface $eventRecurrenceRepositoryInterface
    ) {}

    public function toOutputDto(array $rows)
    {
        $novaLista = [];
        foreach ($rows as $row) {

            $client = $this->clientRepositoryInterface->getById($row['client_id']);
            $user = $this->userRepositoryInterface->getById($row['professional_id']);
            $eventProcedure = $this->eventProcedureRepositoryInterface->getById($row['event_procedure_id']);
            $eventStatus = $this->eventStatusRepositoryInterface->getById($row['event_status_id']);
            $eventColor = $this->eventColorRepositoryInterface->getById($row['event_color_id']);
            $eventRecurrence = $this->eventRecurrenceRepositoryInterface->getById($row['event_recurrence_id']);

            $outputDto = new OutputListEventDTO(
                $row['id'],
                $row['event_type'],
                $client->name,
                $user->name,
                $eventProcedure->name,
                $eventStatus->name,
                $eventColor->hash,
                $row['observation'],
                $row['selected_day_index'],
                $row['date'] = \DateTime::createFromFormat('Y-m-d', $row['date'])->format('d/m/Y'),
                $row['start_event'] = \DateTime::createFromFormat('H:i:s', $row['start_event'])->format('H:i'),
                $row['end_event'] = \DateTime::createFromFormat('H:i:s', $row['end_event'])->format('H:i'),
                $eventRecurrence->name,
            );
            $novaLista[] = $outputDto->toArray();
        }
        return new OutputArrayDTO($novaLista);
    }
}
