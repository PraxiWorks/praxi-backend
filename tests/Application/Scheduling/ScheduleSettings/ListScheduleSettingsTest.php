<?php

namespace Tests\Application\Scheduling\ScheduleSettings;

use App\Application\DTO\IdRequestDTO;
use App\Application\Scheduling\ScheduleSettings\ListScheduleSettings;
use App\Domain\Interfaces\Scheduling\ScheduleSettingsRepositoryInterface;
use Tests\TestCase;

class ListScheduleSettingsTest extends TestCase
{
    private ScheduleSettingsRepositoryInterface $scheduleSettingsRepositoryInterfaceMock;

    private ListScheduleSettings $useCase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->scheduleSettingsRepositoryInterfaceMock = $this->createMock(ScheduleSettingsRepositoryInterface::class);

        $this->useCase = new ListScheduleSettings(
            $this->scheduleSettingsRepositoryInterfaceMock
        );
    }

    public function testExecuteReturnsExpectedResponse()
    {
        // Define o valor de retorno esperado do método list
        $expectedResponse = ['setting1', 'setting2'];
        $this->scheduleSettingsRepositoryInterfaceMock->expects($this->once())->method('list')->willReturn($expectedResponse);

        $input = new IdRequestDTO(1);
        $response = $this->useCase->execute($input);
        $this->assertSame($expectedResponse, $response);
    }
}
