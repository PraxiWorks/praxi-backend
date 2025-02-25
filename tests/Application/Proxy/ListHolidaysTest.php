<?php

namespace Tests\Application\Proxy;

use App\Application\Proxy\DTO\HolidayRequestDTO;
use App\Application\Proxy\ListHolidays;
use App\Domain\Service\Proxy\HolidaysServiceInterface;
use Tests\TestCase;

class ListHolidaysTest extends TestCase
{
    private HolidaysServiceInterface $holidaysServiceInterfaceMock;

    private ListHolidays $useCase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->holidaysServiceInterfaceMock = $this->createMock(HolidaysServiceInterface::class);

        $this->useCase = new ListHolidays(
            $this->holidaysServiceInterfaceMock
        );
    }

    public function testExecuteReturns()
    {
        $holidays = $this->holidaysMock();

        $input = new HolidayRequestDTO(1, 2021);
        $this->holidaysServiceInterfaceMock->expects($this->once())->method('enviarDadosParaApi')->willReturn($holidays);

        $result = $this->useCase->execute($input);

        $this->assertEquals($result, $holidays);
    }

    public function holidaysMock()
    {
        return [
            [
                'id' => 1,
                'name' => 'Holiday 1',
                'date' => '2021-01-01',
                'type' => 'national',
                'description' => 'Description 1',
            ],
            [
                'id' => 2,
                'name' => 'Holiday 2',
                'date' => '2021-02-01',
                'type' => 'national',
                'description' => 'Description 2',
            ],
        ];
    }
}
