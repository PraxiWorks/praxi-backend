<?php

namespace App\Application\Payments\MercadoPago\Customer;

use App\Application\Payments\MercadoPago\Customer\DTO\UpdateCustomerRequestDTO;
use App\Domain\Service\Payments\Customer\CustomerGatewayInterface;

class UpdateCustomer
{
    public function __construct(
        private CustomerGatewayInterface $customerGatewayInterface
    ) {}

    public function execute(UpdateCustomerRequestDTO $input)
    {
        // return $this->customerRepositoryInterface->updateCustomer($input);
    }
}
