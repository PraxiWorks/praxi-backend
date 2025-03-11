<?php

namespace App\Application\Payments\Stripe\Subscription;

use App\Application\DTO\IdRequestDTO;
use App\Domain\Interfaces\Payments\Stripe\Subscription\StripeSubscriptionRepositoryInterface;

class ShowSubscription
{
    public function __construct(
        private StripeSubscriptionRepositoryInterface $stripeSubscriptionRepositoryInterface,
    ) {}

    public function execute(IdRequestDTO $input)
    {
        return $this->stripeSubscriptionRepositoryInterface->getById($input->getId());
    }
}
