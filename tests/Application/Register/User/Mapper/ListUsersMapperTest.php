<?php

namespace Tests\Application\Register\User\Mapper;

use PHPUnit\Framework\TestCase;
use App\Application\Register\User\Mapper\ListUsersMapper;
use App\Application\DTO\OutputArrayDTO;

class ListUsersMapperTest extends TestCase
{
    public function testToOutputDto()
    {
        $mapper = new ListUsersMapper();

        $inputData = [
            'links' => ['self' => 'link'],
            'current_page' => 1,
            'first_page_url' => 'url',
            'from' => 1,
            'last_page' => 1,
            'last_page_url' => 'url',
            'next_page_url' => 'url',
            'path' => 'path',
            'per_page' => 10,
            'prev_page_url' => 'url',
            'to' => 10,
            'total' => 100,
            'data' => [
                [
                    'id' => 1,
                    'name' => 'John Doe',
                    'email' => 'john@example.com',
                    'phone_number' => '1234567890',
                    'status' => 'active'
                ],
            ]
        ];

        $outputDto = $mapper->toOutputDto($inputData);

        $this->assertInstanceOf(OutputArrayDTO::class, $outputDto);
        $this->assertEquals(1, $outputDto->toArray()['meta']['current_page']);
        $this->assertEquals('John Doe', $outputDto->toArray()['users'][0]['name']);
    }
}
