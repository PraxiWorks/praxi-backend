<?php

namespace Tests\Application\Stock\ProductCategory\DTO;

use App\Application\Stock\ProductCategory\DTO\CreateProductCategoryRequestDTO;
use Tests\TestCase;

class CreateProductCategoryRequestDTOTest extends TestCase
{
    public function testInputDTO()
    {
        $input = new CreateProductCategoryRequestDTO(
            1,
            'name',
            true
        );

        $this->assertEquals(1, $input->getCompanyId());
        $this->assertEquals('name', $input->getName());
        $this->assertEquals(true, $input->getStatus());
    }
}
