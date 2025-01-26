<?php

namespace App\Application\Register\Client;

use App\Application\Register\Client\DTO\ListClientRequestDTO;
use App\Domain\Interfaces\Register\Client\ClientRepositoryInterface;

class ListClients
{
    public function __construct(
        private ClientRepositoryInterface $clientRepositoryInterface
    ) {}

    public function execute(ListClientRequestDTO $input): array
    {
        return $this->clientRepositoryInterface->list($input);
    }
}
