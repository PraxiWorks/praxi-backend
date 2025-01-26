<?php

namespace App\Application\Settings\EventProcedure;

use App\Application\Settings\EventProcedure\DTO\ListEventProcedureRequestDTO;
use App\Domain\Interfaces\Settings\EventProcedure\EventProcedureRepositoryInterface;

class ListEventProcedure
{
    public function __construct(
        private EventProcedureRepositoryInterface $eventProcedureRepositoryInterface
    ) {}

    public function execute(ListEventProcedureRequestDTO $input): array
    {
        return $this->eventProcedureRepositoryInterface->list($input);
    }
}
