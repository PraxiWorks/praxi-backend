<?php

namespace App\Application\Register\ClientAddress;

use App\Application\DTO\IdRequestDTO;
use App\Domain\Exceptions\Register\ClientAddress\ClientAddressException;
use App\Domain\Exceptions\Register\ClientAddress\ClientAddressNotFoundException;
use App\Domain\Interfaces\Register\ClientAddress\ClientAddressRepositoryInterface;


class DeleteClientAddress
{
    public function __construct(
        private ClientAddressRepositoryInterface $clientAddressRepositoryInterface
    ) {}

    public function execute(IdRequestDTO $input): bool
    {
        $clientAddress = $this->clientAddressRepositoryInterface->getById($input->getId());
        if (empty($clientAddress)) {
            throw new ClientAddressNotFoundException('Endereço do cliente não encontrado', 400);
        }

        if (!$this->clientAddressRepositoryInterface->delete($clientAddress)) {
            throw new ClientAddressException('Erro ao deletar endereço do cliente', 400);
        }

        return true;
    }
}
