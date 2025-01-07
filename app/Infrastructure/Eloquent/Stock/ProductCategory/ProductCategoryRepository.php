<?php

namespace App\Infrastructure\Eloquent\Stock\ProductCategory;

use App\Domain\Interfaces\Stock\ProductCategory\ProductCategoryRepositoryInterface;
use App\Models\Stock\ProductCategory;

class ProductCategoryRepository implements ProductCategoryRepositoryInterface
{
    public function save(ProductCategory $entity): bool
    {
        return $entity->save();
    }

    public function getById(int $id): ?ProductCategory
    {
        return ProductCategory::find($id);
    }

    public function list(int $empresaId): array
    {
        return ProductCategory::where('company_id', $empresaId)->get()->toArray();
    }

    public function update(ProductCategory $entity): bool
    {
        return $entity->save();
    }

    public function delete(ProductCategory $entity): bool
    {
        return $entity->delete();
    }

    public function getByCompanyIdAndName(int $companyId, string $name): ?ProductCategory
    {
        return ProductCategory::where('company_id', $companyId)->where('name', $name)->first();
    }
}
