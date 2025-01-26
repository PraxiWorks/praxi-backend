<?php

namespace App\Domain\Interfaces\Stock\ProductCategory;

use App\Application\Stock\ProductCategory\DTO\ListProductCategoryRequestDTO;
use App\Models\Stock\ProductCategory;

interface ProductCategoryRepositoryInterface
{
    public function save(ProductCategory $entity): bool;
    public function getById(int $id): ?ProductCategory;
    public function list(ListProductCategoryRequestDTO $input): array;
    public function update(ProductCategory $entity): bool;
    public function delete(ProductCategory $entity): bool;
    public function getByCompanyIdAndName(int $companyId, string $name): ?ProductCategory;
}
