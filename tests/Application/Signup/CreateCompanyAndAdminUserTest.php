<?php

namespace Tests\Application\Scheduling\ScheduleSettings;

use App\Application\Signup\CreateCompanyAndAdminUser;
use App\Application\Signup\DTO\CreateCompanyAndAdminUserRequestDTO;
use App\Domain\Exceptions\Company\CompanyException;
use App\Domain\Exceptions\Scheduling\ScheduleSettings\ScheduleSettingsException;
use App\Domain\Exceptions\Signup\CreateCompanyAndAdminUserException;
use App\Domain\Exceptions\User\UserException;
use App\Domain\Interfaces\Company\CompanyRepositoryInterface;
use App\Domain\Interfaces\Scheduling\ScheduleSettingsRepositoryInterface;
use App\Domain\Interfaces\User\UserRepositoryInterface;
use App\Infrastructure\Services\Jwt\JwtAuth;
use App\Models\Company\Company;
use App\Models\User\User;
use Illuminate\Support\Facades\Config;
use Tests\TestCase;

class CreateCompanyAndAdminUserTest extends TestCase
{
    private CompanyRepositoryInterface $companyRepositoryInterfaceMock;
    private UserRepositoryInterface $userRepositoryInterfaceMock;
    private ScheduleSettingsRepositoryInterface $scheduleSettingsRepositoryInterfaceMock;
    private JwtAuth $jwtAuthMock;

    private CreateCompanyAndAdminUser $useCase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->companyRepositoryInterfaceMock = $this->createMock(CompanyRepositoryInterface::class);
        $this->userRepositoryInterfaceMock = $this->createMock(UserRepositoryInterface::class);
        $this->scheduleSettingsRepositoryInterfaceMock = $this->createMock(ScheduleSettingsRepositoryInterface::class);
        $this->jwtAuthMock = $this->createMock(JwtAuth::class);

        $this->useCase = new CreateCompanyAndAdminUser(
            $this->companyRepositoryInterfaceMock,
            $this->userRepositoryInterfaceMock,
            $this->scheduleSettingsRepositoryInterfaceMock,
            $this->jwtAuthMock
        );
    }

    public function testValidateInputThrowsExceptionForEmptyFantasyName()
    {
        $this->expectException(CompanyException::class);
        $this->expectExceptionMessage('Nome fantasia é obrigatório');

        $input = new CreateCompanyAndAdminUserRequestDTO('', 'username', 'name', 'email', 'phoneNumber', 'password', [['day' => 'seg', 'start_time' => '08:00', 'end_time' => '17:00', 'is_working_day' => true]]);
        $this->useCase->execute($input);
    }

    public function testValidateInputThrowsExceptionForEmptyUsername()
    {
        $this->expectException(UserException::class);
        $this->expectExceptionMessage('Nome de usuário é obrigatório');

        $input = new CreateCompanyAndAdminUserRequestDTO('Fantasy Name', '', 'name', 'email', 'phoneNumber', 'password', [['day' => 'seg', 'start_time' => '08:00', 'end_time' => '17:00', 'is_working_day' => true]]);
        $this->useCase->execute($input);
    }

    public function testValidateInputThrowsExceptionForEmptyName()
    {
        $this->expectException(UserException::class);
        $this->expectExceptionMessage('Nome é obrigatório');

        $input = new CreateCompanyAndAdminUserRequestDTO('Fantasy Name', 'username', '', 'email', 'phoneNumber', 'password', [['day' => 'seg', 'start_time' => '08:00', 'end_time' => '17:00', 'is_working_day' => true]]);
        $this->useCase->execute($input);
    }

    public function testValidateInputThrowsExceptionForEmptyEmail()
    {
        $this->expectException(UserException::class);
        $this->expectExceptionMessage('Email é obrigatório');

        $input = new CreateCompanyAndAdminUserRequestDTO('Fantasy Name', 'username', 'name', '', 'phoneNumber', 'password', [['day' => 'seg', 'start_time' => '08:00', 'end_time' => '17:00', 'is_working_day' => true]]);
        $this->useCase->execute($input);
    }

    public function testValidateInputThrowsExceptionForEmptyPhoneNumber()
    {
        $this->expectException(UserException::class);
        $this->expectExceptionMessage('Telefone é obrigatório');

        $input = new CreateCompanyAndAdminUserRequestDTO('Fantasy Name', 'username', 'name', 'email', '', 'password', [['day' => 'seg', 'start_time' => '08:00', 'end_time' => '17:00', 'is_working_day' => true]]);
        $this->useCase->execute($input);
    }

    public function testValidateInputThrowsExceptionForEmptyPassword()
    {
        $this->expectException(UserException::class);
        $this->expectExceptionMessage('Senha é obrigatória');

        $input = new CreateCompanyAndAdminUserRequestDTO('Fantasy Name', 'username', 'name', 'email', 'phoneNumber', '', [['day' => 'seg', 'start_time' => '08:00', 'end_time' => '17:00', 'is_working_day' => true]]);
        $this->useCase->execute($input);
    }

    public function testValidateInputThrowsExceptionForEmptyWorkSchedule()
    {
        $this->expectException(ScheduleSettingsException::class);
        $this->expectExceptionMessage('Horário de trabalho é obrigatório');

        $input = new CreateCompanyAndAdminUserRequestDTO('Fantasy Name', 'username', 'name', 'email', 'phoneNumber', 'password', []);
        $this->useCase->execute($input);
    }


    public function testFantasyNameAlreadyExists()
    {
        $this->expectException(CreateCompanyAndAdminUserException::class);
        $this->expectExceptionMessage('Uma empresa com este nome já existe');

        $company = new Company();

        $input = new CreateCompanyAndAdminUserRequestDTO('Fantasy Name', 'username', 'name', 'email', 'phoneNumber', 'password', [['day' => 'seg', 'start_time' => '08:00', 'end_time' => '17:00', 'is_working_day' => true]]);
        $this->companyRepositoryInterfaceMock->expects($this->once())->method('getByName')->willReturn($company);

        $this->useCase->execute($input);
    }

    public function testErrorSavingCompany()
    {
        $this->expectException(CreateCompanyAndAdminUserException::class);
        $this->expectExceptionMessage('Erro ao criar a empresa');

        $input = new CreateCompanyAndAdminUserRequestDTO('Fantasy Name', 'username', 'name', 'email', 'phoneNumber', 'password', [['day' => 'seg', 'start_time' => '08:00', 'end_time' => '17:00', 'is_working_day' => true]]);
        $this->companyRepositoryInterfaceMock->expects($this->once())->method('getByName')->willReturn(null);
        $this->companyRepositoryInterfaceMock->expects($this->once())->method('save')->willReturn(false);

        $this->useCase->execute($input);
    }

    public function testEmailAlreadyExists()
    {
        $this->expectException(CreateCompanyAndAdminUserException::class);
        $this->expectExceptionMessage('Email já cadastrado');

        $input = new CreateCompanyAndAdminUserRequestDTO('Fantasy Name', 'username', 'name', 'email', 'phoneNumber', 'password', [['day' => 'seg', 'start_time' => '08:00', 'end_time' => '17:00', 'is_working_day' => true]]);

        $company = new Company();
        $company->id = 1;

        $this->companyRepositoryInterfaceMock->expects($this->exactly(2))->method('getByName')->willReturn(null, $company);
        $this->companyRepositoryInterfaceMock->expects($this->once())->method('save')->willReturn(true);

        $user = new User();;

        $this->userRepositoryInterfaceMock->expects($this->once())->method('getByEmailAndCompanyId')->willReturn($user);

        $this->useCase->execute($input);
    }

    public function testErrorSavingUser()
    {
        $this->expectException(CreateCompanyAndAdminUserException::class);
        $this->expectExceptionMessage('Erro ao criar o usuário');

        $input = new CreateCompanyAndAdminUserRequestDTO('Fantasy Name', 'username', 'name', 'email', 'phoneNumber', 'password', [['day' => 'seg', 'start_time' => '08:00', 'end_time' => '17:00', 'is_working_day' => true]]);

        $company = new Company();
        $company->id = 1;

        $this->companyRepositoryInterfaceMock->expects($this->exactly(2))->method('getByName')->willReturn(null, $company);
        $this->companyRepositoryInterfaceMock->expects($this->once())->method('save')->willReturn(true);

        $this->userRepositoryInterfaceMock->expects($this->once())->method('getByEmailAndCompanyId')->willReturn(null);
        $this->userRepositoryInterfaceMock->expects($this->once())->method('save')->willReturn(false);

        $this->useCase->execute($input);
    }

    public function testInvalidWorkDay()
    {
        $this->expectException(CreateCompanyAndAdminUserException::class);
        $this->expectExceptionMessage('Dia de trabalho inválido.');

        $input = new CreateCompanyAndAdminUserRequestDTO('Fantasy Name', 'username', 'name', 'email', 'phoneNumber', 'password', [['day' => 'cru', 'start_time' => '08:00', 'end_time' => '17:00', 'is_working_day' => true]]);

        $company = new Company();
        $company->id = 1;

        $this->companyRepositoryInterfaceMock->expects($this->exactly(2))->method('getByName')->willReturn(null, $company);
        $this->companyRepositoryInterfaceMock->expects($this->once())->method('save')->willReturn(true);

        $user = new User();
        $user->id = 1;

        $this->userRepositoryInterfaceMock->expects($this->once())->method('getByEmailAndCompanyId')->willReturn(null);
        $this->userRepositoryInterfaceMock->expects($this->once())->method('save')->willReturn(true);
        $this->userRepositoryInterfaceMock->expects($this->once())->method('getByUsername')->willReturn($user);

        $this->useCase->execute($input);
    }

    public function testErrorSavingScheduleSettings()
    {
        $this->expectException(CreateCompanyAndAdminUserException::class);
        $this->expectExceptionMessage('Erro ao salvar configuração de agenda.');

        $input = new CreateCompanyAndAdminUserRequestDTO('Fantasy Name', 'username', 'name', 'email', 'phoneNumber', 'password', [['day' => 'seg', 'start_time' => '08:00', 'end_time' => '17:00', 'is_working_day' => true]]);

        $company = new Company();
        $company->id = 1;

        $this->companyRepositoryInterfaceMock->expects($this->exactly(2))->method('getByName')->willReturn(null, $company);
        $this->companyRepositoryInterfaceMock->expects($this->once())->method('save')->willReturn(true);

        $user = new User();
        $user->id = 1;

        $this->userRepositoryInterfaceMock->expects($this->once())->method('getByEmailAndCompanyId')->willReturn(null);
        $this->userRepositoryInterfaceMock->expects($this->once())->method('save')->willReturn(true);
        $this->userRepositoryInterfaceMock->expects($this->once())->method('getByUsername')->willReturn($user);

        $this->scheduleSettingsRepositoryInterfaceMock->expects($this->once())->method('save')->willReturn(false);

        $this->useCase->execute($input);
    }

    public function testErrorConfigJwt()
    {
        $this->expectException(CreateCompanyAndAdminUserException::class);
        $this->expectExceptionMessage('Configuração JWT inválida: verifique se "secret", "domain" e "expirationTime" estão definidos.');

        $input = new CreateCompanyAndAdminUserRequestDTO('Fantasy Name', 'username', 'name', 'email', 'phoneNumber', 'password', [['day' => 'seg', 'start_time' => '08:00', 'end_time' => '17:00', 'is_working_day' => true]]);

        $company = new Company();
        $company->id = 1;

        $this->companyRepositoryInterfaceMock->expects($this->exactly(2))->method('getByName')->willReturn(null, $company);
        $this->companyRepositoryInterfaceMock->expects($this->once())->method('save')->willReturn(true);

        $user = new User();
        $user->id = 1;

        $this->userRepositoryInterfaceMock->expects($this->once())->method('getByEmailAndCompanyId')->willReturn(null);
        $this->userRepositoryInterfaceMock->expects($this->once())->method('save')->willReturn(true);
        $this->userRepositoryInterfaceMock->expects($this->once())->method('getByUsername')->willReturn($user);

        $this->scheduleSettingsRepositoryInterfaceMock->expects($this->once())->method('save')->willReturn(true);

        Config::set('jwtAuth.secret', null);
        Config::set('jwtAuth.domain', null);
        Config::set('jwtAuth.expirationTime', null);

        $this->useCase->execute($input);
    }

    public function testSuccess()
    {

        $input = new CreateCompanyAndAdminUserRequestDTO('Fantasy Name', 'username', 'name', 'email', 'phoneNumber', 'password', [['day' => 'seg', 'start_time' => '08:00', 'end_time' => '17:00', 'is_working_day' => true]]);

        $company = new Company();
        $company->id = 1;

        $this->companyRepositoryInterfaceMock->expects($this->exactly(2))->method('getByName')->willReturn(null, $company);
        $this->companyRepositoryInterfaceMock->expects($this->once())->method('save')->willReturn(true);

        $user = new User();
        $user->id = 1;

        $this->userRepositoryInterfaceMock->expects($this->once())->method('getByEmailAndCompanyId')->willReturn(null);
        $this->userRepositoryInterfaceMock->expects($this->once())->method('save')->willReturn(true);
        $this->userRepositoryInterfaceMock->expects($this->once())->method('getByUsername')->willReturn($user);

        $this->scheduleSettingsRepositoryInterfaceMock->expects($this->once())->method('save')->willReturn(true);

        $this->jwtAuthMock->expects($this->once())->method('encode')->willReturn('jwtToken');

        $result = $this->useCase->execute($input);

        $this->assertIsArray($result);
        $this->assertArrayHasKey('company', $result);
        $this->assertArrayHasKey('token', $result);
        $this->assertArrayHasKey('user', $result);
        $this->assertEquals($company, $result['company']);
        $this->assertEquals('jwtToken', $result['token']);
        $this->assertEquals($user, $result['user']);
    }
}
