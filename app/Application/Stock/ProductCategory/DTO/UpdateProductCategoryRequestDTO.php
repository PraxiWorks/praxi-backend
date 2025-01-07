<?php

namespace App\Application\Stock\ProductCategory\DTO;

class UpdateProductCategoryRequestDTO
{
    public function __construct(
        private int $companyId,
        private int $id,
        private string $name,
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

    public function getStatus(): bool
    {
        return $this->status;
    }
}
