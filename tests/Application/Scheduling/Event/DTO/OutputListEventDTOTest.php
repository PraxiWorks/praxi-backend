<?php

namespace Tests\Application\Scheduling\Event\DTO;

use PHPUnit\Framework\TestCase;
use App\Application\Scheduling\Event\DTO\OutputListEventDTO;

class OutputListEventDTOTest extends TestCase
{
    public function testOutputDTO()
    {
        $dto = new OutputListEventDTO(
            1,
            'Consultation',
            'John Doe',
            'Dr. Smith',
            'General Checkup',
            'Confirmed',
            'Blue',
            'No observations',
            2,
            '2023-10-10',
            '10:00',
            '11:00',
            'Weekly'
        );

        $expectedArray = [
            'id' => 1,
            'type' => 'Consultation',
            'client' => 'John Doe',
            'professional' => 'Dr. Smith',
            'procedure' => 'General Checkup',
            'status' => 'Confirmed',
            'color' => 'Blue',
            'observations' => 'No observations',
            'selected_day_index' => 2,
            'date' => '2023-10-10',
            'start_time' => '10:00',
            'end_time' => '11:00',
            'recurrence' => 'Weekly',
        ];

        $this->assertEquals($expectedArray, $dto->toArray());
    }
}
