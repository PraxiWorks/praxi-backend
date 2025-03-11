<?php

namespace App\Domain\Service\Payments\Refund;

use App\Models\Payments\Stripe\Subscription\StripeSubscription;

interface RefundGatewayInterface
{
    public function refundPayment(StripeSubscription $subscription, int $userId): bool;
}
