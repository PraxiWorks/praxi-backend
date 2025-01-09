<?php

namespace App\Application\Settings\EventProcedure;

use App\Application\Settings\EventProcedure\DTO\CreateEventProcedureRequestDTO;
use App\Domain\Exceptions\Settings\EventProcedure\EventProcedureException;
use App\Domain\Interfaces\Settings\EventProcedure\EventProcedureRepositoryInterface;
use App\Models\Scheduling\EventProcedure;

class CreateEventProcedure
{
    public function __construct(
        private EventProcedureRepositoryInterface $eventProcedureRepositoryInterface
    ) {}

    public function execute(CreateEventProcedureRequestDTO $input): bool
    {
        $this->validateInput($input);

        if (!empty($this->eventProcedureRepositoryInterface->findByNameAndCompanyId($input->getCompanyId(), $input->getName()))) {
            throw new EventProcedureException('Procedimento já cadastrado', 400);
        }

        $eventProcedure = EventProcedure::new(
            $input->getCompanyId(),
            $input->getName(),
            $input->getStatus()
        );

        if (!$this->eventProcedureRepositoryInterface->save($eventProcedure)) {
            throw new EventProcedureException('Erro ao salvar o procedimento', 500);
        }

        return true;
    }

    private function validateInput(CreateEventProcedureRequestDTO $input): void
    {
        if (empty($input->getName())) {
            throw new EventProcedureException('Nome não informado', 400);
        }
    }
}
