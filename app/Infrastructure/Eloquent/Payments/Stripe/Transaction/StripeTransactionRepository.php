<?php

namespace App\Infrastructure\Eloquent\Payments\Stripe\Transaction;

use App\Domain\Interfaces\Payments\Stripe\Transaction\StripeTransactionRepositoryInterface;
use App\Models\Payments\Stripe\Transaction\StripeTransaction;

class StripeTransactionRepository implements StripeTransactionRepositoryInterface
{
    public function save(StripeTransaction $entity): bool
    {
        return $entity->save();
    }

    public function getBySubscriptionId(string $subscriptionId): StripeTransaction
    {
        return StripeTransaction::where('subscription_id', $subscriptionId)->first();
    }
}
