<?php

namespace Tests\Application\Scheduling\ScheduleSettings\DTO;

use App\Application\Scheduling\ScheduleSettings\DTO\CreateScheduleSettingsRequestDTO;
use Tests\TestCase;

class CreateScheduleSettingsRequestDTOTest extends TestCase
{
    public function testInputDTO()
    {
        $input = new CreateScheduleSettingsRequestDTO(1, [1, 2, 3, 4]);
        $this->assertEquals(1, $input->getCompanyId());
        $this->assertEquals([1, 2, 3, 4], $input->getWorkSchedule());
    }
}
