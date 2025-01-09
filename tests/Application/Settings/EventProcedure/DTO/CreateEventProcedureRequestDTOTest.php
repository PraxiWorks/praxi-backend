<?php

namespace Tests\Application\Settings\EventProcedure\DTO;

use App\Application\Settings\EventProcedure\DTO\CreateEventProcedureRequestDTO;
use Tests\TestCase;

class CreateEventProcedureRequestDTOTest extends TestCase
{
    public function testInputDTO()
    {
        $input = new CreateEventProcedureRequestDTO(
            1,
            'name',
            true
        );

        $this->assertEquals(1, $input->getCompanyId());
        $this->assertEquals('name', $input->getName());
        $this->assertEquals(true, $input->getStatus());
    }
}
