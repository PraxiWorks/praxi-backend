<?php

namespace App\Application\Settings\EventProcedure;

use App\Application\DTO\IdRequestDTO;
use App\Domain\Interfaces\Settings\EventProcedure\EventProcedureRepositoryInterface;

class ListEventProcedure
{
    public function __construct(
        private EventProcedureRepositoryInterface $eventProcedureRepositoryInterface
    ) {}

    public function execute(IdRequestDTO $input): array
    {
        return $this->eventProcedureRepositoryInterface->list($input->getId());
    }
}
