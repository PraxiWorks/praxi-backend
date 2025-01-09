<?php

namespace Tests\Application\Settings\Group\DTO;

use App\Application\Settings\Group\DTO\UpdateGroupRequestDTO;
use Tests\TestCase;

class UpdateGroupRequestDTOTest extends TestCase
{
    public function testInputDTO()
    {
        $input = new UpdateGroupRequestDTO(
            1,
            1,
            'name',
            true
        );

        $this->assertEquals(1, $input->getId());
        $this->assertEquals(1, $input->getCompanyId());
        $this->assertEquals('name', $input->getName());
        $this->assertEquals(true, $input->getStatus());
    }
}
