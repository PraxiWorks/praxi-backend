<?php

namespace App\Domain\Interfaces\Payments\Stripe\Transaction;

use App\Models\Payments\Stripe\Transaction\StripeTransaction;

interface StripeTransactionRepositoryInterface
{
    public function save(StripeTransaction $entity): bool;
    public function getBySubscriptionId(string $subscriptionId): StripeTransaction;
}
