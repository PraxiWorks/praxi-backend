<?php

namespace App\Infrastructure\Eloquent\Payments\Stripe\Refund;

use App\Domain\Interfaces\Payments\Stripe\Refund\StripeRefundRepositoryInterface;
use App\Models\Payments\Stripe\Refund\StripeRefund;

class StripeRefundRepository implements StripeRefundRepositoryInterface
{
    public function save(StripeRefund $entity): bool
    {
        return $entity->save();
    }
}
