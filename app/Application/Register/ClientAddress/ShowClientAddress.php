<?php

namespace App\Application\Register\ClientAddress;

use App\Application\DTO\IdRequestDTO;
use App\Domain\Exceptions\Register\ClientAddress\ClientAddressNotFoundException;
use App\Domain\Interfaces\Register\ClientAddress\ClientAddressRepositoryInterface;
use App\Models\Register\ClientAddress\ClientAddress;

class ShowClientAddress
{

    public function __construct(
        private ClientAddressRepositoryInterface $clientAddressRepositoryInterface
    ) {}

    public function execute(IdRequestDTO $input): ClientAddress
    {
        $clientAddress = $this->clientAddressRepositoryInterface->getById($input->getId());
        if (empty($clientAddress)) {
            throw new ClientAddressNotFoundException('Endereço do cliente não encontrado', 404);
        }

        return $clientAddress;
    }
}
