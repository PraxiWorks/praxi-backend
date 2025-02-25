<?php

namespace Tests\Application\Settings\GroupPermission\DTO;

use App\Application\Settings\GroupPermission\DTO\UpdateGroupPermissionRequestDTO;
use Tests\TestCase;

class UpdateGroupPermissionRequestDTOTest extends TestCase
{
    public function testInputDTO()
    {
        $input = new UpdateGroupPermissionRequestDTO(1, [1, 2, 3]);

        $this->assertEquals(1, $input->getGroupId());
        $this->assertEquals([1, 2, 3], $input->getPermissions());
    }
}
