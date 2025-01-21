<?php

namespace App\Application\Stock\Product\DTO;

class OutputListProductDTO
{
    public function __construct(
        private int $id,
        private string $name,
        private ?string $category,
        private string $skuCode,
        private ?float $price,
        private string $pathImage,
        private string $status,
        private ?int $currentStock,
        private ?int $minimumStockLevel,
        private ?int $maximumStockLevel,
        private ?string $supplier
    ) {}

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'category' => $this->category,
            'sku_code' => $this->skuCode,
            'price' => $this->price,
            'path_image' => $this->pathImage,
            'status' => $this->status,
            'current_stock' => $this->currentStock,
            'minimum_stock_level' => $this->minimumStockLevel,
            'maximum_stock_level' => $this->maximumStockLevel,
            'supplier' => $this->supplier
        ];
    }
}
