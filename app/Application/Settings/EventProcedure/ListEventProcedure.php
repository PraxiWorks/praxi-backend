<?php

namespace App\Application\Settings\EventProcedure;

use App\Application\DTO\OutputArrayDTO;
use App\Application\Settings\EventProcedure\DTO\ListEventProcedureRequestDTO;
use App\Application\Settings\EventProcedure\Mapper\ListEventProceduresMapper;
use App\Domain\Interfaces\Settings\EventProcedure\EventProcedureRepositoryInterface;

class ListEventProcedure
{
    public function __construct(
        private EventProcedureRepositoryInterface $eventProcedureRepositoryInterface,
        private ListEventProceduresMapper $listEventProceduresMapper
    ) {}

    public function execute(ListEventProcedureRequestDTO $input): OutputArrayDTO
    {
        $output = $this->eventProcedureRepositoryInterface->list($input);
        return $this->listEventProceduresMapper->toOutputDto($output);
    }
}
