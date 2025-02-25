<?php

namespace Tests\Application\Settings\GroupPermission\DTO;

use App\Application\Settings\GroupPermission\DTO\AssignPermissionsToGroupRequestDTO;
use Tests\TestCase;

class AssignPermissionsToGroupRequestDTOTest extends TestCase
{
    public function testInputDTO()
    {
        $input = new AssignPermissionsToGroupRequestDTO(1, [1, 2, 3]);

        $this->assertEquals(1, $input->getGroupId());
        $this->assertEquals([1, 2, 3], $input->getPermissions());
    }
}
