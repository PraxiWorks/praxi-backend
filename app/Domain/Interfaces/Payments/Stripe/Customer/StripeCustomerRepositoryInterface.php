<?php

namespace App\Domain\Interfaces\Payments\Stripe\Customer;

use App\Models\Payments\Stripe\Customer\StripeCustomer;

interface StripeCustomerRepositoryInterface
{
    public function save(StripeCustomer $entity): bool;
    public function getById(int $id): StripeCustomer;
}
