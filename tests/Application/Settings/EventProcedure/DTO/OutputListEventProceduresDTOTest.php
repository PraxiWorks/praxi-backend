<?php

use PHPUnit\Framework\TestCase;
use App\Application\Settings\EventProcedure\DTO\OutputListEventProceduresDTO;

class OutputListEventProceduresDTOTest extends TestCase
{
    public function testToArray()
    {
        $dto = new OutputListEventProceduresDTO(1, 'Test Event', true);
        $expectedArray = [
            'id' => 1,
            'name' => 'Test Event',
            'status' => true
        ];

        $this->assertEquals($expectedArray, $dto->toArray());
    }
}
