<?php

namespace App\Application\Settings\EventProcedure;

use App\Application\Settings\EventProcedure\DTO\ListEventProcedureRequestDTO;
use App\Application\Settings\EventProcedure\Mapper\ListEventProceduresMapper;
use App\Domain\Interfaces\Settings\EventProcedure\EventProcedureRepositoryInterface;

class ListEventProcedure
{
    public function __construct(
        private EventProcedureRepositoryInterface $eventProcedureRepositoryInterface,
        private ListEventProceduresMapper $listeventProceduresMapper
    ) {}

    public function execute(ListEventProcedureRequestDTO $input): array
    {
        $output = $this->eventProcedureRepositoryInterface->list($input);
        return $this->listeventProceduresMapper->toOutputDto($output)->toArray();
    }
}
