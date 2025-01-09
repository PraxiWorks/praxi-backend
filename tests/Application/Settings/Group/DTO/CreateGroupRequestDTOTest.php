<?php

namespace Tests\Application\Settings\Group\DTO;

use App\Application\Settings\Group\DTO\CreateGroupRequestDTO;
use Tests\TestCase;

class CreateGroupRequestDTOTest extends TestCase
{
    public function testInputDTO()
    {
        $input = new CreateGroupRequestDTO(
            1,
            'name',
            true
        );

        $this->assertEquals(1, $input->getCompanyId());
        $this->assertEquals('name', $input->getName());
        $this->assertEquals(true, $input->getStatus());
    }
}
