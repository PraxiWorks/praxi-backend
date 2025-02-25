<?php

namespace Tests\Application\Settings\EventProcedure\Mapper;

use PHPUnit\Framework\TestCase;
use App\Application\Settings\EventProcedure\Mapper\ListEventProceduresMapper;
use App\Application\DTO\OutputArrayDTO;
use App\Application\Settings\EventProcedure\DTO\OutputListEventProceduresDTO;

class ListEventProceduresMapperTest extends TestCase
{
    private ListEventProceduresMapper $listEventProceduresMapper;

    protected function setUp(): void
    {
        $this->listEventProceduresMapper = new ListEventProceduresMapper();
    }

    public function testToOutputDto()
    {
        $rows = [
            'links' => [
                'first' => 'http://example.com?page=1',
                'last' => 'http://example.com?page=2',
                'prev' => null,
                'next' => 'http://example.com?page=2',
            ],
            'current_page' => 1,
            'from' => 1,
            'last_page' => 2,
            'path' => 'http://example.com',
            'per_page' => 15,
            'to' => 15,
            'total' => 30,
            'first_page_url' => 'http://example.com?page=1',
            'last_page_url' => 'http://example.com?page=2',
            'next_page_url' => 'http://example.com?page=2',
            'prev_page_url' => null,
            'data' => [
                [
                    'id' => 1,
                    'name' => 'Procedure1',
                    'status' => 'active',
                ],
                [
                    'id' => 2,
                    'name' => 'Procedure2',
                    'status' => 'inactive',
                ],
            ],
        ];

        $outputDto = $this->listEventProceduresMapper->toOutputDto($rows);

        $expectedDto = new OutputArrayDTO([
            'links' => $rows['links'],
            'meta' => [
                'current_page' => 1,
                'first_page_url' => 'http://example.com?page=1',
                'from' => 1,
                'last_page' => 2,
                'last_page_url' => 'http://example.com?page=2',
                'next_page_url' => 'http://example.com?page=2',
                'path' => 'http://example.com',
                'per_page' => 15,
                'prev_page_url' => null,
                'to' => 15,
                'total' => 30,
            ],
            'procedures' => [
                (new OutputListEventProceduresDTO(1, 'Procedure1', 'active'))->toArray(),
                (new OutputListEventProceduresDTO(2, 'Procedure2', 'inactive'))->toArray(),
            ],
        ]);

        $this->assertInstanceOf(OutputArrayDTO::class, $outputDto);
        $this->assertEquals($expectedDto->toArray(), $outputDto->toArray());
    }
}
