<?php

namespace Tests\Application\Settings\Group\DTO;

use PHPUnit\Framework\TestCase;
use App\Application\Settings\Group\DTO\OutputListGroupsDTO;

class OutputListGroupsDTOTest extends TestCase
{
    public function testToArray()
    {
        $dto = new OutputListGroupsDTO(1, 'Group Name', true);
        $expectedArray = [
            'id' => 1,
            'name' => 'Group Name',
            'status' => true
        ];

        $this->assertEquals($expectedArray, $dto->toArray());
    }
}
