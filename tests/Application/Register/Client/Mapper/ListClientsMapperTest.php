<?php

namespace Tests\Application\Register\Client\Mapper;

use PHPUnit\Framework\TestCase;
use App\Application\Register\Client\Mapper\ListClientsMapper;
use App\Application\DTO\OutputArrayDTO;

class ListClientsMapperTest extends TestCase
{
    public function testToOutputDto()
    {
        $mapper = new ListClientsMapper();

        $inputData = [
            'links' => ['self' => 'link'],
            'current_page' => 1,
            'first_page_url' => 'url',
            'from' => 1,
            'last_page' => 10,
            'last_page_url' => 'url',
            'next_page_url' => 'url',
            'path' => 'path',
            'per_page' => 15,
            'prev_page_url' => 'url',
            'to' => 15,
            'total' => 150,
            'data' => [
                [
                    'id' => 1,
                    'name' => 'Client 1',
                    'email' => 'client1@example.com',
                    'phone_number' => '123456789',
                    'status' => 'active'
                ],
                [
                    'id' => 2,
                    'name' => 'Client 2',
                    'email' => 'client2@example.com',
                    'phone_number' => '987654321',
                    'status' => 'inactive'
                ]
            ]
        ];

        $outputDto = $mapper->toOutputDto($inputData);

        $this->assertInstanceOf(OutputArrayDTO::class, $outputDto);
        $this->assertEquals($inputData['links'], $outputDto->toArray()['links']);
        $this->assertEquals($inputData['current_page'], $outputDto->toArray()['meta']['current_page']);
        $this->assertCount(2, $outputDto->toArray()['clients']);
    }
}
