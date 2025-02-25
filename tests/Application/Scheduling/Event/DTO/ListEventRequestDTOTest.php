<?php

namespace Tests\Application\Scheduling\Event\DTO;

use App\Application\Scheduling\Event\DTO\ListEventRequestDTO;
use Tests\TestCase;

class ListEventRequestDTOTest extends TestCase
{
    public function testInputDTO()
    {
        $input = new ListEventRequestDTO(
            1,
            '2021-10-10',
            '2021-10-10',
            1,
            1,
            1
        );

        $this->assertEquals(1, $input->getCompanyId());
        $this->assertEquals('2021-10-10', $input->getStartDay());
        $this->assertEquals('2021-10-10', $input->getEndDay());
        $this->assertEquals(1, $input->getProfessionalId());
        $this->assertEquals(1, $input->getClientId());
        $this->assertEquals(1, $input->getProcedureId());
    }
}
