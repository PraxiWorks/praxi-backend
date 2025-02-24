<?php

namespace App\Application\Register\Client;

use App\Application\Register\Client\DTO\ListClientRequestDTO;
use App\Application\Register\Client\Mapper\ListClientsMapper;
use App\Domain\Interfaces\Register\Client\ClientRepositoryInterface;

class ListClients
{
    public function __construct(
        private ClientRepositoryInterface $clientRepositoryInterface,
        private ListClientsMapper $listClientsMapper
    ) {}

    public function execute(ListClientRequestDTO $input): array
    {
        $output = $this->clientRepositoryInterface->list($input);
        return $this->listClientsMapper->toOutputDto($output)->toArray();
    }
}
