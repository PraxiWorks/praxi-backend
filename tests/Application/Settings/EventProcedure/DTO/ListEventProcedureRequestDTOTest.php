<?php

namespace Tests\Application\Settings\EventProcedure\DTO;

use App\Application\Settings\EventProcedure\DTO\ListEventProcedureRequestDTO;
use Tests\TestCase;

class ListEventProcedureRequestDTOTest extends TestCase
{
    public function testInputDTO()
    {
        $input = new ListEventProcedureRequestDTO(1, true, 'name', 1, 15);

        $this->assertEquals(1, $input->getCompanyId());
        $this->assertEquals(true, $input->getStatus());
        $this->assertEquals('name', $input->getSearchQuery());
        $this->assertEquals(1, $input->getPage());
        $this->assertEquals(15, $input->getPerPage());
    }
}
