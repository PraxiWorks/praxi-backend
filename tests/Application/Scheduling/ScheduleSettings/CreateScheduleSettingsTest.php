<?php

namespace Tests\Application\Scheduling\ScheduleSettings;

use App\Application\Scheduling\ScheduleSettings\CreateScheduleSettings;
use App\Application\Scheduling\ScheduleSettings\DTO\CreateScheduleSettingsRequestDTO;
use App\Domain\Exceptions\Company\CompanyException;
use App\Domain\Exceptions\Scheduling\ScheduleSettings\ScheduleSettingsException;
use App\Domain\Interfaces\Company\CompanyRepositoryInterface;
use App\Domain\Interfaces\Scheduling\ScheduleSettingsRepositoryInterface;
use App\Models\Company\Company;
use App\Models\Scheduling\ScheduleSettings;
use Tests\TestCase;

class CreateScheduleSettingsTest extends TestCase
{
    private CompanyRepositoryInterface $companyRepositoryInterfaceMock;
    private ScheduleSettingsRepositoryInterface $scheduleSettingsRepositoryInterfaceMock;

    private CreateScheduleSettings $useCase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->companyRepositoryInterfaceMock = $this->createMock(CompanyRepositoryInterface::class);
        $this->scheduleSettingsRepositoryInterfaceMock = $this->createMock(ScheduleSettingsRepositoryInterface::class);

        $this->useCase = new CreateScheduleSettings(
            $this->companyRepositoryInterfaceMock,
            $this->scheduleSettingsRepositoryInterfaceMock
        );
    }

    public function testCompanyNotFound()
    {
        $this->expectException(CompanyException::class);
        $this->expectExceptionMessage('Empresa não encontrada.');

        $input = new CreateScheduleSettingsRequestDTO(1, []);
        $this->companyRepositoryInterfaceMock->expects($this->once())->method('getCompanyById')->willReturn(null);

        $this->useCase->execute($input);
    }

    public function testScheduleSettingsAlreadyExists()
    {
        $this->expectException(ScheduleSettingsException::class);
        $this->expectExceptionMessage('Já existe uma configuração de agenda cadastrada para esta empresa');

        $company = new Company();
        $company->id = 1;

        $scheduleSettingsMock = $this->createMock(ScheduleSettings::class);

        $input = new CreateScheduleSettingsRequestDTO(1, []);
        $this->companyRepositoryInterfaceMock->expects($this->once())->method('getCompanyById')->willReturn($company);
        $this->scheduleSettingsRepositoryInterfaceMock->expects($this->once())->method('getScheduleSettingsByCompanyId')->willReturn($scheduleSettingsMock);

        $this->useCase->execute($input);
    }

    public function testNoWorkScheduleSelected()
    {
        $this->expectException(ScheduleSettingsException::class);
        $this->expectExceptionMessage('É necessário selecionar pelo menos um dia de trabalho.');

        $company = new Company();
        $company->id = 1;

        $input = new CreateScheduleSettingsRequestDTO(1, []);
        $this->companyRepositoryInterfaceMock->expects($this->once())->method('getCompanyById')->willReturn($company);
        $this->scheduleSettingsRepositoryInterfaceMock->expects($this->once())->method('getScheduleSettingsByCompanyId')->willReturn(null);

        $this->useCase->execute($input);
    }

    public function testInvalidWorkDay()
    {
        $this->expectException(ScheduleSettingsException::class);
        $this->expectExceptionMessage('Dia de trabalho inválido.');

        $company = new Company();
        $company->id = 1;

        $input = new CreateScheduleSettingsRequestDTO(1, [['day' => 'invalid', 'start_time' => '08:00', 'end_time' => '17:00', 'is_working_day' => true]]);
        $this->companyRepositoryInterfaceMock->expects($this->once())->method('getCompanyById')->willReturn($company);
        $this->scheduleSettingsRepositoryInterfaceMock->expects($this->once())->method('getScheduleSettingsByCompanyId')->willReturn(null);

        $this->useCase->execute($input);
    }

    public function testErrorSavingScheduleSettings()
    {
        $this->expectException(ScheduleSettingsException::class);
        $this->expectExceptionMessage('Erro ao salvar configuração de agenda.');

        $company = new Company();
        $company->id = 1;

        $input = new CreateScheduleSettingsRequestDTO(1, [['day' => 'seg', 'start_time' => '08:00', 'end_time' => '17:00', 'is_working_day' => true]]);
        $this->companyRepositoryInterfaceMock->expects($this->once())->method('getCompanyById')->willReturn($company);
        $this->scheduleSettingsRepositoryInterfaceMock->expects($this->once())->method('getScheduleSettingsByCompanyId')->willReturn(null);
        $this->scheduleSettingsRepositoryInterfaceMock->expects($this->once())->method('save')->willReturn(false);

        $this->useCase->execute($input);
    }

    public function testSuccess()
    {
        $company = new Company();
        $company->id = 1;

        $input = new CreateScheduleSettingsRequestDTO(1, [['day' => 'seg', 'start_time' => '08:00', 'end_time' => '17:00', 'is_working_day' => true]]);
        $this->companyRepositoryInterfaceMock->expects($this->once())->method('getCompanyById')->willReturn($company);
        $this->scheduleSettingsRepositoryInterfaceMock->expects($this->once())->method('getScheduleSettingsByCompanyId')->willReturn(null);
        $this->scheduleSettingsRepositoryInterfaceMock->expects($this->once())->method('save')->willReturn(true);

        $result = $this->useCase->execute($input);
        $this->assertTrue($result);
    }
}
