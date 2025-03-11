<?php

namespace App\Application\Payments\Stripe\Customer;

use App\Application\Payments\Stripe\Customer\DTO\CreateCustomerRequestDTO;
use App\Domain\Service\Payments\Customer\CustomerGatewayInterface;

class CreateCustomer
{
    public function __construct(
        private CustomerGatewayInterface $customerGatewayInterface
    ) {}

    public function execute(CreateCustomerRequestDTO $input): object
    {
        return $this->customerGatewayInterface->createCustomer($input);
    }
}
