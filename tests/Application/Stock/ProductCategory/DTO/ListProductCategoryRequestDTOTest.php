<?php

namespace Tests\Application\Stock\ProductCategory\DTO;

use App\Application\Stock\ProductCategory\DTO\ListProductCategoryRequestDTO;
use Tests\TestCase;

class ListProductCategoryRequestDTOTest extends TestCase
{
    public function testInputDTO()
    {
        $input = new ListProductCategoryRequestDTO(
            1,
            true
        );

        $this->assertEquals(1, $input->getCompanyId());
        $this->assertEquals(true, $input->getStatus());
    }
}
