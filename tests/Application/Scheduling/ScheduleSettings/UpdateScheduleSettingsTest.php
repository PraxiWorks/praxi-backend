<?php

namespace Tests\Application\Scheduling\ScheduleSettings;

use App\Application\Scheduling\ScheduleSettings\DTO\UpdateScheduleSettingsRequestDTO;
use App\Application\Scheduling\ScheduleSettings\UpdateScheduleSettings;
use App\Domain\Exceptions\Scheduling\ScheduleSettings\ScheduleSettingsException;
use App\Domain\Interfaces\Scheduling\ScheduleSettingsRepositoryInterface;
use App\Models\Scheduling\ScheduleSettings;
use Tests\TestCase;

class UpdateScheduleSettingsTest extends TestCase
{
    private ScheduleSettingsRepositoryInterface $scheduleSettingsRepositoryInterfaceMock;

    private UpdateScheduleSettings $useCase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->scheduleSettingsRepositoryInterfaceMock = $this->createMock(ScheduleSettingsRepositoryInterface::class);

        $this->useCase = new UpdateScheduleSettings(
            $this->scheduleSettingsRepositoryInterfaceMock
        );
    }

    public function testValidateInputThrowsExceptionForEmptyDayOfWeek()
    {
        $this->expectException(ScheduleSettingsException::class);
        $this->expectExceptionMessage('Dia da semana é obrigatório');

        $input = new UpdateScheduleSettingsRequestDTO(1, '', '08:00', '17:00', true);
        $this->useCase->execute($input);
    }

    public function testValidateInputThrowsExceptionForEmptyStartTime()
    {
        $this->expectException(ScheduleSettingsException::class);
        $this->expectExceptionMessage('Hora de início é obrigatório');

        $input = new UpdateScheduleSettingsRequestDTO(1, 'seg', '', '17:00', true);
        $this->useCase->execute($input);
    }

    public function testValidateInputThrowsExceptionForEmptyEndTime()
    {
        $this->expectException(ScheduleSettingsException::class);
        $this->expectExceptionMessage('Hora de término é obrigatório');

        $input = new UpdateScheduleSettingsRequestDTO(1, 'seg', '08:00', '', true);
        $this->useCase->execute($input);
    }

    public function testValidateInputThrowsExceptionForEmptyIsWorkingDay()
    {
        $this->expectException(ScheduleSettingsException::class);
        $this->expectExceptionMessage('Dia de trabalho é obrigatório');

        $input = new UpdateScheduleSettingsRequestDTO(1, 'seg', '08:00', '17:00', '');
        $this->useCase->execute($input);
    }

    public function testValidateInputThrowsExceptionForMultipleErrors()
    {
        $this->expectException(ScheduleSettingsException::class);
        $this->expectExceptionMessage('Dia da semana é obrigatório, Hora de início é obrigatório, Hora de término é obrigatório, Dia de trabalho é obrigatório');

        $input = new UpdateScheduleSettingsRequestDTO(1, '', '', '', '');
        $this->useCase->execute($input);
    }

    public function testScheduleSettingsNotFound()
    {
        $this->expectException(ScheduleSettingsException::class);
        $this->expectExceptionMessage('Configuração de agenda não encontrada');

        $input = new UpdateScheduleSettingsRequestDTO(1, 'seg', '08:00', '17:00', true);
        $this->scheduleSettingsRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn(null);

        $this->useCase->execute($input);
    }

    public function testErrorUpdatingScheduleSettings()
    {
        $this->expectException(ScheduleSettingsException::class);
        $this->expectExceptionMessage('Erro ao atualizar configuração de agenda');

        $scheduleSettings = new ScheduleSettings();

        $input = new UpdateScheduleSettingsRequestDTO(1, 'seg', '08:00', '17:00', true);
        $this->scheduleSettingsRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn($scheduleSettings);
        $this->scheduleSettingsRepositoryInterfaceMock->expects($this->once())->method('update')->willReturn(false);

        $this->useCase->execute($input);
    }

    public function testSuccess()
    {
        $input = new UpdateScheduleSettingsRequestDTO(1, 'seg', '08:00', '17:00', true);

        $scheduleSettings = new ScheduleSettings();

        $this->scheduleSettingsRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn($scheduleSettings);
        $this->scheduleSettingsRepositoryInterfaceMock->expects($this->once())->method('update')->willReturn(true);

        $this->useCase->execute($input);

        $this->assertTrue(true);
    }
}
