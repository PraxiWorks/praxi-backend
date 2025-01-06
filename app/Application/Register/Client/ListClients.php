<?php

namespace App\Application\Register\Client;

use App\Application\DTO\IdRequestDTO;
use App\Domain\Interfaces\Register\Client\ClientRepositoryInterface;

class ListClients
{
    public function __construct(
        private ClientRepositoryInterface $clientRepositoryInterface
    ) {}

    public function execute(IdRequestDTO $input): array
    {
        return $this->clientRepositoryInterface->list($input->getId());
    }
}
