<?php

namespace App\Application\Scheduling\Event;

use App\Application\DTO\IdRequestDTO;
use App\Domain\Exceptions\Scheduling\Event\EventNotFoundException;
use App\Domain\Interfaces\Scheduling\EventRepositoryInterface;
use App\Models\Scheduling\Event;

class ShowEvent
{
    public function __construct(
        private EventRepositoryInterface $eventRepositoryInterface
    ) {}

    public function execute(IdRequestDTO $input): Event
    {
        $product = $this->eventRepositoryInterface->getById($input->getId());
        if (empty($product)) {
            throw new EventNotFoundException();
        }

        return $product;
    }
}
