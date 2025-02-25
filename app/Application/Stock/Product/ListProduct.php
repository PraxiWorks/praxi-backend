<?php

namespace App\Application\Stock\Product;

use App\Application\DTO\OutputArrayDTO;
use App\Application\Stock\Product\DTO\ListProductRequestDTO;
use App\Application\Stock\Product\Mapper\ListProductMapper;
use App\Domain\Interfaces\Stock\Product\ProductRepositoryInterface;

class ListProduct
{
    public function __construct(
        private ProductRepositoryInterface $productRepositoryInterface,
        private ListProductMapper $listProductMapper
    ) {}

    public function execute(ListProductRequestDTO $input): OutputArrayDTO
    {
        $result = $this->productRepositoryInterface->list($input);
        return $this->listProductMapper->toOutputDto($result);
    }
}
