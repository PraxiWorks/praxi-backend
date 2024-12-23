<?php

namespace Tests\Application\Login\DTO;

use App\Application\Stock\Product\DTO\CreateProductRequestDTO;
use Tests\TestCase;

class CreateProductRequestDTOTest extends TestCase
{
    public function testInputDTO()
    {
        $input = new CreateProductRequestDTO(
            1,
            'name',
            'category_id',
            'sku_code',
            1.0,
            'image_base_64',
            'current_stock',
            'minimum_stock_level',
            'maximum_stock_level',
            true
        );

        $this->assertEquals(1, $input->getCompanyId());
        $this->assertEquals('name', $input->getName());
        $this->assertEquals('category_id', $input->getCategoryId());
        $this->assertEquals('sku_code', $input->getSkuCode());
        $this->assertEquals(1.0, $input->getPrice());
        $this->assertEquals('image_base_64', $input->getImageBase64());
        $this->assertEquals('current_stock', $input->getCurrentStock());
        $this->assertEquals('minimum_stock_level', $input->getMinimumStockLevel());
        $this->assertEquals('maximum_stock_level', $input->getMaximumStockLevel());
        $this->assertEquals(true, $input->getStatus());
    }
}
