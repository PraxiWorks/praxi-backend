<?php

namespace Tests\Application\Scheduling\Event\DTO;

use App\Application\Scheduling\Event\DTO\UpdateEventRequestDTO;
use Tests\TestCase;

class UpdateEventRequestDTOTest extends TestCase
{
    public function testInputDTO()
    {
        $input = new UpdateEventRequestDTO(
            1,
            1,
            1,
            1,
            1,
            1,
            1,
            1,
            'observation',
            '2021-10-10',
            '10:00',
            '11:00',
            1,
        );

        $this->assertEquals(1, $input->getCompanyId());
        $this->assertEquals(1, $input->getCompanyId());
        $this->assertEquals(1, $input->getEventType());
        $this->assertEquals(1, $input->getClientId());
        $this->assertEquals(1, $input->getProfessionalId());
        $this->assertEquals(1, $input->getEventProcedureId());
        $this->assertEquals(1, $input->getEventStatusId());
        $this->assertEquals(1, $input->getEventColorId());
        $this->assertEquals('observation', $input->getObservation());
        $this->assertEquals('2021-10-10', $input->getDay());
        $this->assertEquals('10:00', $input->getStartEvent());
        $this->assertEquals('11:00', $input->getEndEvent());
        $this->assertEquals(1, $input->getEventRecurrenceId());
    }
}
