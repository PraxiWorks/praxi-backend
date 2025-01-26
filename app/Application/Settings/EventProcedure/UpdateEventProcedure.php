<?php

namespace App\Application\Settings\EventProcedure;

use App\Application\Settings\EventProcedure\DTO\UpdateEventProcedureRequestDTO;
use App\Domain\Exceptions\Settings\EventProcedure\EventProcedureException;
use App\Domain\Exceptions\Settings\EventProcedure\EventProcedureNotFoundException;
use App\Domain\Interfaces\Settings\EventProcedure\EventProcedureRepositoryInterface;

class UpdateEventProcedure
{
    public function __construct(
        private EventProcedureRepositoryInterface $eventProcedureRepositoryInterface
    ) {}

    public function execute(UpdateEventProcedureRequestDTO $input): bool
    {
        $this->validateInput($input);

        $eventProcedure = $this->eventProcedureRepositoryInterface->getById($input->getId());
        if (empty($eventProcedure)) {
            throw new EventProcedureNotFoundException();
        }

        if ($input->getName() != $eventProcedure->name) {
            if (!empty($this->eventProcedureRepositoryInterface->findByNameAndCompanyId($input->getCompanyId(), $input->getName()))) {
                throw new EventProcedureException('Já existe um procedimento com esse nome', 400);
            }
        }

        $eventProcedure->name = $input->getName();
        $eventProcedure->status = $input->getStatus();

        if (!$this->eventProcedureRepositoryInterface->update($eventProcedure)) {
            throw new EventProcedureException('Erro ao atualizar o procedimento', 500);
        }

        return true;
    }

    private function validateInput(UpdateEventProcedureRequestDTO $input): void
    {
        if (empty($input->getName())) {
            throw new EventProcedureException('Nome não informado', 400);
        }
    }
}
