<?php

namespace App\Application\Scheduling\Event;

use App\Domain\Interfaces\Scheduling\EventStatusRepositoryInterface;

class ListEventStatus
{
    public function __construct(
       private EventStatusRepositoryInterface $eventStatusRepositoryInterface
    ) {}

    public function execute(): array
    {
        return $this->eventStatusRepositoryInterface->list();
    }
}
