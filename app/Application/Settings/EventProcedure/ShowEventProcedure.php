<?php

namespace App\Application\Settings\EventProcedure;

use App\Application\DTO\IdRequestDTO;
use App\Domain\Exceptions\Settings\EventProcedure\EventProcedureNotFoundException;
use App\Domain\Interfaces\Settings\EventProcedure\EventProcedureRepositoryInterface;
use App\Models\Scheduling\EventProcedure;

class ShowEventProcedure
{
    public function __construct(
        private EventProcedureRepositoryInterface $eventProcedureRepositoryInterface
    ) {}

    public function execute(IdRequestDTO $input): EventProcedure
    {
        $eventProcedure = $this->eventProcedureRepositoryInterface->getById($input->getId());
        if (empty($eventProcedure)) {
            throw new EventProcedureNotFoundException();
        }

        return $eventProcedure;
    }
}
