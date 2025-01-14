<?php

namespace App\Application\Payments\Customer;

use App\Application\Payments\Customer\DTO\CreateCustomerRequestDTO;
use App\Domain\Exceptions\Register\Client\ClientException;
use App\Domain\Service\Payments\Customer\CustomerGateway;

class CreateCustomer
{
    public function __construct(
        private CustomerGateway $customerGateway
    ) {}

    public function execute(CreateCustomerRequestDTO $input): bool
    {
        $this->validateInput($input);
        $this->customerGateway->save($input->toArray());
        return true;
    }

    private function validateInput(CreateCustomerRequestDTO $input): void
    {
        $requiredFields = [
            'Email' => $input->getEmail()
        ];

        foreach ($requiredFields as $field => $value) {
            if (empty($value)) {
                throw new ClientException("{$field} é obrigatório", 400);
            }
        }
    }
}
