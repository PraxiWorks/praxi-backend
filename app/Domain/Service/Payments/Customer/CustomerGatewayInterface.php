<?php

namespace App\Domain\Service\Payments\Customer;

use App\Application\Payments\Stripe\Customer\DTO\CreateCustomerRequestDTO;
use App\Models\Payments\Stripe\Customer\StripeCustomer;

interface CustomerGatewayInterface
{
    public function createCustomer(CreateCustomerRequestDTO $input): StripeCustomer;
}
