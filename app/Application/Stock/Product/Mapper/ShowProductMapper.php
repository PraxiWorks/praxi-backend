<?php

namespace App\Application\Stock\Product\Mapper;

use App\Application\DTO\OutputArrayDTO;
use App\Application\Stock\Product\DTO\OutputProductDTO;
use App\Infrastructure\Eloquent\Stock\ProductCategory\ProductCategoryRepository;
use App\Infrastructure\Eloquent\Stock\Supplier\SupplierRepository;
use App\Models\Stock\Product;

class ShowProductMapper
{

    public function __construct(
        private ProductCategoryRepository $productCategoryRepository,
        private SupplierRepository $supplierRepository
    ) {}

    public function toOutputDto(Product $product): OutputProductDTO
    {

        $productCategory = !empty($product->category_id) ? $this->productCategoryRepository->getById($product->category_id) : null;
        $supplier = !empty($product->supplier_id) ? $this->supplierRepository->getById($product->supplier_id) : null;

        $outputProductDto = new OutputProductDTO(
            $product->id,
            $product->name,
            $product->category_id,
            $productCategory->name ?? null,
            $product->sku_code,
            $product->price,
            $product->path_image,
            $product->status,
            $product->current_stock,
            $product->minimum_stock_level,
            $product->maximum_stock_level,
            $product->supplier_id,
            $supplier->name ?? null
        );

        return $outputProductDto;
    }
}
