<?php

namespace App\Application\Payments\Stripe\Subscription\DTO;

class SubscriptionRequestDTO
{
    public function __construct(
        private int $module,
        private int $companyId,
        private int $userId,
        private string $email,
        private string $name,
        private string $cardToken,
        private string $priceId
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

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCardToken(): string
    {
        return $this->cardToken;
    }

    public function getPriceId(): string
    {
        return $this->priceId;
    }
}
