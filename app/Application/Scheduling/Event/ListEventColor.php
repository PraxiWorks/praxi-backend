<?php

namespace App\Application\Scheduling\Event;

use App\Domain\Interfaces\Scheduling\EventColorRepositoryInterface;

class ListEventColor
{
    public function __construct(
        private EventColorRepositoryInterface $eventColorRepositoryInterface
    ) {}

    public function execute(): array
    {
        return $this->eventColorRepositoryInterface->list();
    }
}
