<?php

namespace Tests\Application\Register\UserPermission\DTO;

use App\Application\Register\UserPermission\DTO\AssignPermissionsToUserRequestDTO;
use Tests\TestCase;

class AssignPermissionsToUserRequestDTOTest extends TestCase
{
    public function testInputDTO()
    {
        $input = new AssignPermissionsToUserRequestDTO(
            1,
            [1, 2, 3]
        );

        $this->assertEquals(1, $input->getUserId());
        $this->assertEquals([1, 2, 3], $input->getPermissions());
    }
}
