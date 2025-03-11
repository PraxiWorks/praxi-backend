<?php

namespace App\Domain\Interfaces\Payments\Stripe\Subscription;

use App\Models\Payments\Stripe\Subscription\StripeSubscription;

interface StripeSubscriptionRepositoryInterface
{
    public function save(StripeSubscription $entity): bool;
    public function getById(int $id): StripeSubscription;
    public function getByCompanyId(int $userId): ?StripeSubscription;
    public function update(StripeSubscription $entity): bool;
}
