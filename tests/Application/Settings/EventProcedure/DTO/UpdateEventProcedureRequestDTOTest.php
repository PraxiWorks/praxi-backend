<?php

namespace Tests\Application\Settings\EventProcedure\DTO;

use App\Application\Settings\EventProcedure\DTO\UpdateEventProcedureRequestDTO;
use Tests\TestCase;

class UpdateEventProcedureRequestDTOTest extends TestCase
{
    public function testInputDTO()
    {
        $input = new UpdateEventProcedureRequestDTO(
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
