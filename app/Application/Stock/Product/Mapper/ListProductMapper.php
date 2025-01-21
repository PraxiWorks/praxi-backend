<?php

namespace App\Application\Stock\Product\Mapper;

use App\Application\DTO\OutputArrayDTO;
use App\Application\Stock\Product\DTO\OutputListProductDTO;
use App\Infrastructure\Eloquent\Stock\ProductCategory\ProductCategoryRepository;
use App\Infrastructure\Eloquent\Stock\Supplier\SupplierRepository;

class ListProductMapper
{

    public function __construct(
        private ProductCategoryRepository $productCategoryRepository,
        private SupplierRepository $supplierRepository
    ) {}

    public function toOutputDto(array $rows): OutputArrayDTO
    {
        $novaLista = [];
        foreach ($rows as $row) {
            $productCategory = !empty($row['category_id']) ? $this->productCategoryRepository->getById($row['category_id']) : null;
            $supplier = !empty($row['supplier_id']) ? $this->supplierRepository->getById($row['supplier_id']) : null;

            $outputDto = new OutputListProductDTO(
                $row['id'],
                $row['name'],
                $productCategory->name ?? null,
                $row['sku_code'],
                $row['price'],
                $row['path_image'],
                $row['status'],
                $row['current_stock'],
                $row['minimum_stock_level'],
                $row['maximum_stock_level'],
                $supplier->name ?? null
            );
            $novaLista[] = $outputDto->toArray();
        }
        return new OutputArrayDTO($novaLista);
    }
}
