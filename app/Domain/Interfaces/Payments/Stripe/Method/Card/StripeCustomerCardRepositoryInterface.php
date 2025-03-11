<?php

namespace App\Domain\Interfaces\Payments\Stripe\Method\Card;

use App\Models\Payments\Stripe\Method\Card\StripeCustomerCard;

interface StripeCustomerCardRepositoryInterface
{
    public function save(StripeCustomerCard $entity): bool;
    public function getById(int $id): StripeCustomerCard;
}
