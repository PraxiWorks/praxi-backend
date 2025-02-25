<?php

namespace Tests\Application\Settings\Permission\DTO;

use App\Application\Settings\Permission\DTO\ListPermissionsRequestDTO;
use Tests\TestCase;

class ListPermissionsRequestDTOTest extends TestCase
{
    public function testInputDTO()
    {
        $input = new ListPermissionsRequestDTO(1, [1, 2, 3]);

        $this->assertEquals(1, $input->getCompanyId());
        $this->assertEquals([1, 2, 3], $input->getPermissions());
    }
}
