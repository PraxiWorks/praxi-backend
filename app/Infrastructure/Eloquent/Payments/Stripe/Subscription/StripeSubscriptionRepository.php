<?php

namespace App\Infrastructure\Eloquent\Payments\Stripe\Subscription;

use App\Domain\Interfaces\Payments\Stripe\Subscription\StripeSubscriptionRepositoryInterface;
use App\Models\Payments\Stripe\Subscription\StripeSubscription;

class StripeSubscriptionRepository implements StripeSubscriptionRepositoryInterface
{
    public function save(StripeSubscription $entity): bool
    {
        return $entity->save();
    }

    public function getById(int $id): StripeSubscription
    {
        return StripeSubscription::findOrFail($id);
    }

    public function getByCompanyId(int $userId): ?StripeSubscription
    {
        return StripeSubscription::where('company_id', $userId)->orderBy('id', 'desc')->first();
    }

    public function update(StripeSubscription $entity): bool
    {
        return $entity->save();
    }
}
