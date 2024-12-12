<?php

namespace Tests\Application\Scheduling\ScheduleSettings\DTO;

use App\Application\DTO\IdInputDTO;
use Tests\TestCase;

class IdInputDTOTest extends TestCase
{
    public function testInputDTO()
    {
        $input = new IdInputDTO(1);
        $this->assertEquals(1, $input->getId());
    }
}
