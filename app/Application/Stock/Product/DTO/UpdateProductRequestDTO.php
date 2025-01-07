<?php

namespace App\Application\Stock\Product\DTO;

class UpdateProductRequestDTO
{
    public function __construct(
        private int $companyId,
        private int $productId,
        private string $name,
        private ?string $categoryId,
        private string $skuCode,
        private ?float $price,
        private ?string $imageBase64,
        private ?string $currentStock,
        private ?string $minimumStockLevel,
        private ?string $maximumStockLevel,
        private bool $status
    ) {}

    public function getCompanyId(): int
    {
        return $this->companyId;
    }

    public function getProductId(): int
    {
        return $this->productId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCategoryId(): ?string
    {
        return $this->categoryId;
    }

    public function getSkuCode(): string
    {
        return $this->skuCode;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function getImageBase64(): ?string
    {
        return $this->imageBase64;
    }

    public function getCurrentStock(): ?string
    {
        return $this->currentStock;
    }

    public function getMinimumStockLevel(): ?string
    {
        return $this->minimumStockLevel;
    }

    public function getMaximumStockLevel(): ?string
    {
        return $this->maximumStockLevel;
    }

    public function getStatus(): bool
    {
        return $this->status;
    }
}
