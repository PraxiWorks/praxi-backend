<?php

namespace App\Application\Register\Client;

use App\Application\DTO\IdRequestDTO;
use App\Domain\Exceptions\Register\Client\ClientException;
use App\Domain\Exceptions\Register\Client\ClientNotFoundException;
use App\Domain\Interfaces\Register\Client\ClientRepositoryInterface;
use App\Domain\Interfaces\Scheduling\EventRepositoryInterface;

class DeleteClient
{

    public function __construct(
        private ClientRepositoryInterface $clientRepositoryInterface,
        private EventRepositoryInterface $eventRepositoryInterface
    ) {}

    public function execute(IdRequestDTO $input): bool
    {

        $client = $this->clientRepositoryInterface->getById($input->getId());
        if (empty($client)) {
            throw new ClientNotFoundException('Cliente não encontrado', 400);
        }

        if (!empty($this->eventRepositoryInterface->getByClientId($client->id))) {
            throw new ClientException('Cliente possui eventos cadastrados', 400);
        }

        if (!$this->clientRepositoryInterface->delete($client)) {
            throw new ClientException('Erro ao deletar cliente', 400);
        }

        return true;
    }
}
