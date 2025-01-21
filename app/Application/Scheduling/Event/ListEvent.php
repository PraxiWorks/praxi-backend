<?php

namespace App\Application\Scheduling\Event;

use App\Application\DTO\OutputArrayDTO;
use App\Application\Scheduling\Event\DTO\ListEventRequestDTO;
use App\Application\Scheduling\Event\Mapper\ListEventMapper;
use App\Domain\Interfaces\Scheduling\EventRepositoryInterface;

class ListEvent
{
    public function __construct(
       private EventRepositoryInterface $eventRepositoryInterface,
       private ListEventMapper $listEventMapper
    ) {}

    public function execute(ListEventRequestDTO $input): OutputArrayDTO
    {
        $result = $this->eventRepositoryInterface->list($input);
        return $this->listEventMapper->toOutputDto($result);
    }
}
