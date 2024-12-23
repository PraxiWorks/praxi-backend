<?php

namespace App\Infrastructure\Eloquent\Stock\Product;

use App\Domain\Interfaces\Stock\Product\ProductRepositoryInterface;
use App\Models\Stock\Product;

class ProductRepository implements ProductRepositoryInterface
{
    public function save(Product $entity): bool
    {
        return $entity->save();
    }

    public function getById(int $id): ?Product
    {
        return Product::find($id);
    }

    public function list(int $empresaId): array
    {
        return Product::where('company_id', $empresaId)->get()->toArray();
    }

    public function update(Product $entity): bool
    {
        return $entity->save();
    }

    public function delete(Product $entity): bool
    {
        return $entity->delete();
    }

    public function getBySkuCode(string $skuCode): ?Product
    {
        return Product::where('sku_code', $skuCode)->first();
    }
}
