<?php

namespace App\Application\Register\Client;

use App\Application\DTO\IdRequestDTO;
use App\Domain\Exceptions\Register\Client\ClientNotFoundException;
use App\Domain\Interfaces\Register\Client\ClientRepositoryInterface;
use App\Models\Register\Client\Client;

class ShowClient
{

    public function __construct(
        private ClientRepositoryInterface $clientRepositoryInterface
    ) {}

    public function execute(IdRequestDTO $input): Client
    {
        $client = $this->clientRepositoryInterface->getById($input->getId());
        if (empty($client)) {
            throw new ClientNotFoundException('Cliente não encontrado', 404);
        }

        return $client;
    }
}
