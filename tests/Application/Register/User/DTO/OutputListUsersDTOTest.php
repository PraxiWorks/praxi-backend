<?php

namespace Tests\Application\Register\User\DTO;

use PHPUnit\Framework\TestCase;
use App\Application\Register\User\DTO\OutputListUsersDTO;

class OutputListUsersDTOTest extends TestCase
{
    public function testToArray()
    {
        $dto = new OutputListUsersDTO(
            1,
            'John Doe',
            'john.doe@example.com',
            '1234567890',
            true
        );

        $expectedArray = [
            'id' => 1,
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'phone_number' => '1234567890',
            'status' => true
        ];

        $this->assertEquals($expectedArray, $dto->toArray());
    }
}
