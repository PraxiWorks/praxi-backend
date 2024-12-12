<?php

namespace Tests\Application\Scheduling\ScheduleSettings;

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

        // Chama o método execute e verifica se o retorno é o esperado
        $response = $this->useCase->execute();
        $this->assertSame($expectedResponse, $response);
    }
}
