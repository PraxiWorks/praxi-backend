<?php

namespace Tests\Application\Scheduling\ScheduleSettings\DTO;

use App\Application\Scheduling\ScheduleSettings\DTO\ScheduleSettingsUpdateInputDTO;
use Tests\TestCase;

class ScheduleSettingsUpdateInputDTOTest extends TestCase
{
    public function testInputDTO()
    {
        $input = new ScheduleSettingsUpdateInputDTO(1, 'seg', '08:00', '17:00', true);
        $this->assertEquals(1, $input->getId());
        $this->assertEquals('seg', $input->getDayOfWeek());
        $this->assertEquals('08:00', $input->getStartTime());
        $this->assertEquals('17:00', $input->getEndTime());
        $this->assertEquals(true, $input->getIsWorkingDay());
    }
}
