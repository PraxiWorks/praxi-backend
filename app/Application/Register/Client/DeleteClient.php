<?php

namespace App\Application\Register\Client;

use App\Application\DTO\IdRequestDTO;
use App\Domain\Exceptions\Register\Client\ClientException;
use App\Domain\Exceptions\Register\Client\ClientNotFoundException;
use App\Domain\Interfaces\Register\Client\ClientRepositoryInterface;

class DeleteClient
{

    public function __construct(
        private ClientRepositoryInterface $clientRepositoryInterface
    ) {}

    public function execute(IdRequestDTO $input): bool
    {

        $client = $this->clientRepositoryInterface->getById($input->getId());
        if (empty($client)) {
            throw new ClientNotFoundException('Cliente não encontrado', 400);
        }

        if (!$this->clientRepositoryInterface->delete($client)) {
            throw new ClientException('Erro ao deletar cliente', 400);
        }

        return true;
    }
}
