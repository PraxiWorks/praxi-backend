<?php

namespace App\Application\Register\ClientAddress;

use App\Application\Register\ClientAddress\DTO\UpdateClientAddressRequestDTO;
use App\Domain\Exceptions\Register\ClientAddress\ClientAddressException;
use App\Domain\Exceptions\Register\ClientAddress\ClientAddressNotFoundException;
use App\Domain\Interfaces\Register\ClientAddress\ClientAddressRepositoryInterface;
class UpdateClientAddress
{

    public function __construct(
        private ClientAddressRepositoryInterface $clientAddressRepositoryInterface
    ) {}

    public function execute(UpdateClientAddressRequestDTO $input): bool
    {
        $this->validateInput($input);

        $clientAddress = $this->clientAddressRepositoryInterface->getById($input->getId());
        if (empty($clientAddress)) {
            throw new ClientAddressNotFoundException('Endereço do cliente não encontrado', 400);
        }


        $clientAddress->client_id = $input->getClientId();
        $clientAddress->country = $input->getCountry();
        $clientAddress->zip_code = $input->getZipCode();
        $clientAddress->state = $input->getState();
        $clientAddress->city = $input->getCity();
        $clientAddress->neighborhood = $input->getNeighborhood();
        $clientAddress->street = $input->getStreet();
        $clientAddress->number = $input->getNumber();
        $clientAddress->complement = $input->getComplement();

        if (!$this->clientAddressRepositoryInterface->update($clientAddress)) {
            throw new ClientAddressException('Erro ao atualizar endereço do cliente', 400);
        }

        return true;
    }

    private function validateInput(UpdateClientAddressRequestDTO $input): void
    {
        $requiredFields = [
            'Pais' => $input->getCountry(),
            'Estado' => $input->getState(),
            'Cidade' => $input->getCity()
        ];

        foreach ($requiredFields as $field => $value) {
            if (empty($value)) {
                throw new ClientAddressException("{$field} é obrigatório", 400);
            }
        }
    }
}
