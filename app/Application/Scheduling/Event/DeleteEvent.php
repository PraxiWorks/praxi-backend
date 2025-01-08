<?php

namespace App\Application\Scheduling\Event;

use App\Application\DTO\IdRequestDTO;
use App\Domain\Exceptions\Scheduling\Event\EventException;
use App\Domain\Exceptions\Scheduling\Event\EventNotFoundException;
use App\Domain\Interfaces\Scheduling\EventRepositoryInterface;

class DeleteEvent
{

    public function __construct(
        private EventRepositoryInterface $eventRepositoryInterface,
    ) {}

    public function execute(IdRequestDTO $input): bool
    {
        $event = $this->eventRepositoryInterface->getById($input->getId());
        if (empty($event)) {
            throw new EventNotFoundException('Evento não encontrado', 404);
        }

        if (!$this->eventRepositoryInterface->delete($event)) {
            throw new EventException('Erro ao deletar o evento', 500);
        }

        return true;
    }
}
