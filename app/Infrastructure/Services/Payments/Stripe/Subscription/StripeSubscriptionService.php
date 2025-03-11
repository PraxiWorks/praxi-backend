<?php

namespace App\Infrastructure\Services\Payments\Stripe\Subscription;

use App\Application\Payments\Stripe\Subscription\DTO\CreateSubscriptionRequestDTO;
use Stripe\Subscription;

class StripeSubscriptionService
{
    public function createStripeSubscription(CreateSubscriptionRequestDTO $input): object
    {
        return Subscription::create([
            'customer' => $input->getCustomerId(),
            'items' => [['price' => $input->getPriceId()]],
            'expand' => ['latest_invoice.payment_intent']
        ]);
    }
}
