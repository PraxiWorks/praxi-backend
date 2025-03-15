<?php

namespace App\Application\Payments\Stripe\Customer\DTO;

class UpdateCustomerRequestDTO
{

    public function __construct(
        public string $id,
        public ?string $firstName,
        public ?string $lastName
    ) {}

    public function getId(): string
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }
}
