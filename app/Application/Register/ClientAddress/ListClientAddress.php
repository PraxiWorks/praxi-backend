<?php

namespace App\Application\Register\ClientAddress;

use App\Application\DTO\IdRequestDTO;
use App\Domain\Interfaces\Register\ClientAddress\ClientAddressRepositoryInterface;

class ListClientAddress
{
    public function __construct(
        private ClientAddressRepositoryInterface $clientAddressRepositoryInterface
    ) {}

    public function execute(IdRequestDTO $input): array
    {
        return $this->clientAddressRepositoryInterface->list($input->getId());
    }
}
