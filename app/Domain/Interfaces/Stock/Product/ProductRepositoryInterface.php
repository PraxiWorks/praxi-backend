<?php

namespace App\Domain\Interfaces\Stock\Product;

use App\Models\Stock\Product;

interface ProductRepositoryInterface
{
    public function save(Product $entity): bool;
    public function getById(int $id): ?Product;
    public function list(int $empresaId): array;
    public function update(Product $entity): bool;
    public function delete (Product $entity): bool;
    public function getBySkuCode(string $skuCode): ?Product;
}
