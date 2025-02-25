<?php

namespace App\Domain\Interfaces\Stock\Product;

use App\Application\Stock\Product\DTO\ListProductRequestDTO;
use App\Models\Stock\Product;

interface ProductRepositoryInterface
{
    public function save(Product $entity): bool;
    public function getById(int $id): ?Product;
    public function list(ListProductRequestDTO $input): array;
    public function update(Product $entity): bool;
    public function delete (Product $entity): bool;
    public function getBySkuCode(string $skuCode): ?Product;
    public function getByCategoryId(int $categoryId): array;
    public function getBySupplierId(int $supplierId): array;
}
