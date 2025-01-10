<?php

namespace App\Application\Register\ClientAddress\DTO;

class CreateClientAddressRequestDTO
{

    public function __construct(
        private int $clientId,
        private string $country,
        private ?string $zipCode,
        private string $state,
        private string $city,
        private ?string $neighborhood,
        private ?string $street,
        private ?int $number,
        private ?string $complement
    ) {}

    public function getClientId(): int
    {
        return $this->clientId;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function getZipCode(): ?string
    {
        return $this->zipCode;
    }

    public function getState(): string
    {
        return $this->state;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function getNeighborhood(): ?string
    {
        return $this->neighborhood;
    }

    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function getNumber(): ?int
    {
        return $this->number;
    }

    public function getComplement(): ?string
    {
        return $this->complement;
    }
}
