<?php

namespace Tests\Application\Register\UserPermission\DTO;

use App\Application\Register\UserPermission\DTO\UpdateUserPermissionRequestDTO;
use Tests\TestCase;

class UpdateUserPermissionRequestDTOTest extends TestCase
{
    public function testInputDTO()
    {
        $input = new UpdateUserPermissionRequestDTO(
            1,
            [1, 2, 3]
        );

        $this->assertEquals(1, $input->getUserId());
        $this->assertEquals([1, 2, 3], $input->getPermissions());
    }
}
