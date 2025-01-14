<?php

namespace App\Application\Payments\Customer\DTO;

use Illuminate\Support\Facades\Date;

class CreateCustomerRequestDTO
{

    public function __construct(
        public string $email,
        public ?string $firstName,
        public ?string $lastName,
        public ?array $phone,
        public ?array $indentification,
        public ?string $defaultAddress,
        public ?array $address,
        public ?string $dateRegistered,
        public ?string $description,
        public ?string $defaultCard
    ) {}

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function getPhone(): ?array
    {
        return $this->phone;
    }

    public function getIndentification(): ?array
    {
        return $this->indentification;
    }

    public function getDefaultAddress(): ?string
    {
        return $this->defaultAddress;
    }

    public function getAddress(): ?array
    {
        return $this->address;
    }

    public function getDateRegistered(): ?Date
    {
        return $this->dateRegistered;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getDefaultCard(): ?string
    {
        return $this->defaultCard;
    }

    public function toArray(): array
    {
        return [
            'email' => $this->email,
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'phone' => $this->phone,
            'indentification' => $this->indentification,
            'default_address' => $this->defaultAddress,
            'address' => $this->address,
            'date_registered' => $this->dateRegistered,
            'description' => $this->description,
            'default_card' => $this->defaultCard
        ];
    }
}
