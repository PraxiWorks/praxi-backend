<?php

namespace App\Application\Settings\EventProcedure;

use App\Application\DTO\IdRequestDTO;
use App\Domain\Exceptions\Settings\EventProcedure\EventProcedureException;
use App\Domain\Exceptions\Settings\EventProcedure\EventProcedureNotFoundException;
use App\Domain\Interfaces\Settings\EventProcedure\EventProcedureRepositoryInterface;

class DeleteEventProcedure
{
    public function __construct(
        private EventProcedureRepositoryInterface $eventProcedureRepositoryInterface
    ) {}

    public function execute(IdRequestDTO $input): bool
    {
        $eventProcedure = $this->eventProcedureRepositoryInterface->getById($input->getId());
        if (empty($eventProcedure)) {
            throw new EventProcedureNotFoundException('Procedimento não encontrado', 404);
        }

        if (!$this->eventProcedureRepositoryInterface->delete($eventProcedure)) {
            throw new EventProcedureException('Erro ao deletar procedimento', 500);
        }

        return true;
    }
}
