<?php

namespace Tests\Application\Settings\Group\Mapper;

use PHPUnit\Framework\TestCase;
use App\Application\Settings\Group\Mapper\ListGroupsMapper;
use App\Application\DTO\OutputArrayDTO;

class ListGroupsMapperTest extends TestCase
{
    public function testToOutputDto()
    {
        $mapper = new ListGroupsMapper();

        $input = [
            'links' => ['self' => 'link'],
            'current_page' => 1,
            'first_page_url' => 'first_page_url',
            'from' => 1,
            'last_page' => 10,
            'last_page_url' => 'last_page_url',
            'next_page_url' => 'next_page_url',
            'path' => 'path',
            'per_page' => 15,
            'prev_page_url' => 'prev_page_url',
            'to' => 15,
            'total' => 150,
            'data' => [
                [
                    'id' => 1,
                    'name' => 'Group 1',
                    'status' => 'active'
                ],
                [
                    'id' => 2,
                    'name' => 'Group 2',
                    'status' => 'inactive'
                ]
            ]
        ];

        $output = $mapper->toOutputDto($input);

        $this->assertInstanceOf(OutputArrayDTO::class, $output);
        $this->assertEquals(1, $output->toArray()['meta']['current_page']);
        $this->assertCount(2, $output->toArray()['groups']);
        $this->assertEquals('Group 1', $output->toArray()['groups'][0]['name']);
        $this->assertEquals('inactive', $output->toArray()['groups'][1]['status']);
    }
}
