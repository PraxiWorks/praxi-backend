<?php

namespace Tests\Application\Stock\ProductCategory\DTO;

use App\Application\Stock\ProductCategory\DTO\UpdateProductCategoryRequestDTO;
use Tests\TestCase;

class UpdateProductCategoryRequestDTOTest extends TestCase
{
    public function testInputDTO()
    {
        $input = new UpdateProductCategoryRequestDTO(
            1,
            1,
            'name',
            true
        );

        $this->assertEquals(1, $input->getCompanyId());
        $this->assertEquals(1, $input->getId());
        $this->assertEquals('name', $input->getName());
        $this->assertEquals(true, $input->getStatus());
    }
}
