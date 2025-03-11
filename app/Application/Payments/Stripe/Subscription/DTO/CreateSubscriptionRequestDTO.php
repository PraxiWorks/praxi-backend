<?php

namespace App\Application\Payments\Stripe\Subscription\DTO;

class CreateSubscriptionRequestDTO
{
    public function __construct(
        public int $module,
        public int $companyId,
        public int $userId,
        public string $customerId,
        public string $priceId
    ) {}

    public function getModule(): int
    {
        return $this->module;
    }

    public function getCompanyId(): int
    {
        return $this->companyId;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getCustomerId(): string
    {
        return $this->customerId;
    }

    public function getPriceId(): string
    {
        return $this->priceId;
    }
}
