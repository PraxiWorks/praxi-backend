<?php

namespace App\Application\Scheduling\Event;

use App\Application\DTO\IdRequestDTO;
use App\Domain\Interfaces\Scheduling\EventRepositoryInterface;

class ListEvent
{
    public function __construct(
       private EventRepositoryInterface $eventRepositoryInterface
    ) {}

    public function execute(IdRequestDTO $input): array
    {
        return $this->eventRepositoryInterface->list($input->getId());
    }
}
