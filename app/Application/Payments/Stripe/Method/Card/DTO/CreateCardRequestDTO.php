<?php

namespace App\Application\Payments\Stripe\Method\Card\DTO;

class CreateCardRequestDTO
{
    public function __construct(
        public int $companyId,
        public int $stripeCustomerId,
        public string $customerId,
        public string $cardToken
    ) {}

    public function getCompanyId(): int
    {
        return $this->companyId;
    }

    public function getStripeCustomerId(): int
    {
        return $this->stripeCustomerId;
    }

    public function getCustomerId(): string
    {
        return $this->customerId;
    }

    public function getCardToken(): string
    {
        return $this->cardToken;
    }
}
