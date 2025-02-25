<?php

namespace Tests\Application\Register\Client\DTO;

use PHPUnit\Framework\TestCase;
use App\Application\Register\Client\DTO\OutputListClientsDTO;

class OutputListClientsDTOTest extends TestCase
{
    public function testToArray()
    {
        $dto = new OutputListClientsDTO(
            id: 1,
            name: 'John Doe',
            email: 'john.doe@example.com',
            phoneNumber: '123456789',
            status: true
        );

        $expectedArray = [
            'id' => 1,
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'phone_number' => '123456789',
            'status' => true
        ];

        $this->assertEquals($expectedArray, $dto->toArray());
    }
}
