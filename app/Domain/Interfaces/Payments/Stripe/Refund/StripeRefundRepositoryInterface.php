<?php

namespace App\Domain\Interfaces\Payments\Stripe\Refund;

use App\Models\Payments\Stripe\Refund\StripeRefund;

interface StripeRefundRepositoryInterface
{
    public function save(StripeRefund $entity): bool;
}
