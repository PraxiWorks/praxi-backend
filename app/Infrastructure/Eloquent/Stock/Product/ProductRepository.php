<?php

namespace App\Infrastructure\Eloquent\Stock\Product;

use App\Application\Stock\Product\DTO\ListProductRequestDTO;
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

    public function list(ListProductRequestDTO $input): array
    {
        $query = Product::where('company_id', $input->getCompanyId());

        if (!empty($input->getStatus())) {
            $query->where('status', $input->getStatus());
        }

        $query->orderBy('id', 'desc');

        return $query->get()->toArray();
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

    public function getByCategoryId(int $categoryId): array
    {
        return Product::where('category_id', $categoryId)->get()->toArray();
    }

    public function getBySupplierId(int $supplierId): array
    {
        return Product::where('supplier_id', $supplierId)->get()->toArray();
    }
}
