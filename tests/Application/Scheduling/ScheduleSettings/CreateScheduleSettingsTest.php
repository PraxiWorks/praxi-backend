<?php

namespace Tests\Application\Scheduling\ScheduleSettings;

use App\Application\Scheduling\ScheduleSettings\CreateScheduleSettings;
use App\Application\Scheduling\ScheduleSettings\DTO\CreateScheduleSettingsRequestDTO;
use App\Domain\Exceptions\Scheduling\ScheduleSettings\ScheduleSettingsException;
use App\Domain\Interfaces\Scheduling\ScheduleSettingsRepositoryInterface;
use App\Models\Scheduling\ScheduleSettings;
use Tests\TestCase;

class CreateScheduleSettingsTest extends TestCase
{
    private ScheduleSettingsRepositoryInterface $scheduleSettingsRepositoryInterfaceMock;

    private CreateScheduleSettings $useCase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->scheduleSettingsRepositoryInterfaceMock = $this->createMock(ScheduleSettingsRepositoryInterface::class);

        $this->useCase = new CreateScheduleSettings(
            $this->scheduleSettingsRepositoryInterfaceMock
        );
    }


    public function testScheduleSettingsAlreadyExists()
    {
        $this->expectException(ScheduleSettingsException::class);
        $this->expectExceptionMessage('Já existe uma configuração de agenda cadastrada para esta empresa');

        $scheduleSettingsMock = $this->createMock(ScheduleSettings::class);

        $input = new CreateScheduleSettingsRequestDTO(1, []);
        $this->scheduleSettingsRepositoryInterfaceMock->expects($this->once())->method('getScheduleSettingsByCompanyId')->willReturn($scheduleSettingsMock);

        $this->useCase->execute($input);
    }

    public function testNoWorkScheduleSelected()
    {
        $this->expectException(ScheduleSettingsException::class);
        $this->expectExceptionMessage('É necessário selecionar pelo menos um dia de trabalho.');

        $input = new CreateScheduleSettingsRequestDTO(1, []);
        $this->scheduleSettingsRepositoryInterfaceMock->expects($this->once())->method('getScheduleSettingsByCompanyId')->willReturn(null);

        $this->useCase->execute($input);
    }

    public function testInvalidWorkDay()
    {
        $this->expectException(ScheduleSettingsException::class);
        $this->expectExceptionMessage('Dia de trabalho inválido.');

        $input = new CreateScheduleSettingsRequestDTO(1, [['day' => 'invalid', 'start_time' => '08:00', 'end_time' => '17:00', 'is_working_day' => true]]);
        $this->scheduleSettingsRepositoryInterfaceMock->expects($this->once())->method('getScheduleSettingsByCompanyId')->willReturn(null);

        $this->useCase->execute($input);
    }

    public function testErrorSavingScheduleSettings()
    {
        $this->expectException(ScheduleSettingsException::class);
        $this->expectExceptionMessage('Erro ao salvar configuração de agenda.');

        $input = new CreateScheduleSettingsRequestDTO(1, [['day' => 'seg', 'start_time' => '08:00', 'end_time' => '17:00', 'is_working_day' => true]]);
        $this->scheduleSettingsRepositoryInterfaceMock->expects($this->once())->method('getScheduleSettingsByCompanyId')->willReturn(null);
        $this->scheduleSettingsRepositoryInterfaceMock->expects($this->once())->method('save')->willReturn(false);

        $this->useCase->execute($input);
    }

    public function testSuccess()
    {
        $input = new CreateScheduleSettingsRequestDTO(1, [['day' => 'seg', 'start_time' => '08:00', 'end_time' => '17:00', 'is_working_day' => true]]);
        $this->scheduleSettingsRepositoryInterfaceMock->expects($this->once())->method('getScheduleSettingsByCompanyId')->willReturn(null);
        $this->scheduleSettingsRepositoryInterfaceMock->expects($this->once())->method('save')->willReturn(true);

        $result = $this->useCase->execute($input);
        $this->assertTrue($result);
    }
}
