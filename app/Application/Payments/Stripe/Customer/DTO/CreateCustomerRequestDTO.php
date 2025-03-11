<?php

namespace App\Application\Payments\Stripe\Customer\DTO;

class CreateCustomerRequestDTO
{

    public function __construct(
        public int $companyId,
        public int $userId,
        public string $email,
        public string $name
    ) {}

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
}
