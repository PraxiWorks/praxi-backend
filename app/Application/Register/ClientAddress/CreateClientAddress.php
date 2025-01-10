<?php

namespace App\Application\Register\ClientAddress;

use App\Application\Register\ClientAddress\DTO\CreateClientAddressRequestDTO;
use App\Domain\Exceptions\Register\ClientAddress\ClientAddressException;
use App\Domain\Interfaces\Register\ClientAddress\ClientAddressRepositoryInterface;
use App\Models\Register\ClientAddress\ClientAddress;

class CreateClientAddress
{
    public function __construct(
        private ClientAddressRepositoryInterface $clientAddressRepositoryInterface
    ) {}

    public function execute(CreateClientAddressRequestDTO $input): bool
    {

        $this->validateInput($input);

        if (!empty($this->clientAddressRepositoryInterface->getByClientId($input->getClientId()))) {
            throw new ClientAddressException('Endereço já cadastrado para este cliente', 400);
        }

        $clientAddress = ClientAddress::new(
            $input->getClientId(),
            $input->getCountry(),
            $input->getZipCode(),
            $input->getState(),
            $input->getCity(),
            $input->getNeighborhood(),
            $input->getStreet(),
            $input->getNumber(),
            $input->getComplement()
        );

        if (!$this->clientAddressRepositoryInterface->save($clientAddress)) {
            throw new ClientAddressException('Erro ao salvar endereço', 500);
        }

        return true;
    }

    private function validateInput(CreateClientAddressRequestDTO $input): void
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
