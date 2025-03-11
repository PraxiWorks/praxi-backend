<?php

namespace App\Domain\Service\Payments\Subscription;

use App\Application\Payments\Stripe\Subscription\DTO\CreateSubscriptionRequestDTO;
use App\Models\Payments\Stripe\Subscription\StripeSubscription;

interface SubscriptionGatewayInterface
{
    public function createSubscription(CreateSubscriptionRequestDTO $input): StripeSubscription;
}
