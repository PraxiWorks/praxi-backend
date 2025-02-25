<?php

namespace App\Infrastructure\Eloquent\Stock\ProductCategory;

use App\Application\Stock\ProductCategory\DTO\ListProductCategoryRequestDTO;
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

    public function list(ListProductCategoryRequestDTO $input): array
    {
        $query = ProductCategory::where('company_id', $input->getCompanyId());

        if (!empty($input->getStatus())) {
            $query->where('status', $input->getStatus());
        }

        $query->orderBy('id', 'desc');

        return $query->get()->toArray();
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
