<?php

namespace App\Application\Scheduling\Event;

use App\Domain\Interfaces\Scheduling\EventRecurrenceRepositoryInterface;

class ListEventRecurrence
{
    public function __construct(
        private EventRecurrenceRepositoryInterface $eventRecurrenceRepositoryInterface
    ) {}

    public function execute(): array
    {
        return $this->eventRecurrenceRepositoryInterface->list();
    }
}
