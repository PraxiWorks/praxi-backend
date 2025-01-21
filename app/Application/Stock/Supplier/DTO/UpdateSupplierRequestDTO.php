<?php

namespace App\Application\Stock\Supplier\DTO;

class UpdateSupplierRequestDTO
{

    public function __construct(
        private int $companyId,
        private int $id,
        private string $name,
        private string $phoneNumber,
        private string $cnpjNumber,
        private string $imageBase64,
        private bool $status,
    ) {}

    public function getCompanyId(): int
    {
        return $this->companyId;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPhoneNumber(): string
    {
        return $this->phoneNumber;
    }

    public function getCnpjNumber(): string
    {
        return $this->cnpjNumber;
    }

    public function getImageBase64(): string
    {
        return $this->imageBase64;
    }

    public function getStatus(): bool
    {
        return $this->status;
    }
}
