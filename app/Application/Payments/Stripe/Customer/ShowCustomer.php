<?php

namespace App\Application\Payments\MercadoPago\Customer;

use App\Application\Payments\MercadoPago\Customer\DTO\ShowCustomerRequestDTO;
use App\Domain\Service\Payments\Customer\CustomerGatewayInterface;

class ShowCustomer
{
    public function __construct(
        private CustomerGatewayInterface $customerGatewayInterface
    ) {}

    public function execute(ShowCustomerRequestDTO $input)
    {
        // return $this->customerGatewayInterface->showCustomer($input->getId());
    }
}
