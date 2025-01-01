<?php

namespace Tests\Application\Signup;

use App\Application\Signup\CreateCompanyAndAdminUser;
use App\Application\Signup\DTO\CreateCompanyAndAdminUserRequestDTO;
use App\Domain\Exceptions\Company\CompanyException;
use App\Domain\Exceptions\Register\User\UserException;
use App\Domain\Exceptions\Scheduling\ScheduleSettings\ScheduleSettingsException;
use App\Domain\Exceptions\Signup\CreateCompanyAndAdminUserException;
use App\Domain\Interfaces\Core\Company\CompanyRepositoryInterface;
use App\Domain\Interfaces\Core\Module\ModuleRepositoryInterface;
use App\Domain\Interfaces\Core\Permission\ModulePermissionRepositoryInterface;
use App\Domain\Interfaces\Core\Plan\PlanModuleRepositoryInterface;
use App\Domain\Interfaces\Core\Plan\PlanRepositoryInterface;
use App\Domain\Interfaces\Register\Group\GroupPermissionRepositoryInterface;
use App\Domain\Interfaces\Register\Group\GroupRepositoryInterface;
use App\Domain\Interfaces\Register\User\UserRepositoryInterface;
use App\Domain\Interfaces\Scheduling\ScheduleSettingsRepositoryInterface;
use App\Domain\Interfaces\Settings\Company\CompanyModuleRepositoryInterface;
use App\Domain\Interfaces\Settings\Company\CompanyPlanRepositoryInterface;
use App\Infrastructure\Services\Jwt\JwtAuth;
use App\Models\Core\Company\Company;
use App\Models\Core\Module\Module;
use App\Models\Core\Plan\Plan;
use App\Models\Core\Plan\PlanModule;
use App\Models\Register\User\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Config;
use stdClass;
use Tests\TestCase;

class CreateCompanyAndAdminUserTest extends TestCase
{
    private PlanRepositoryInterface $planRepositoryInterfaceMock;
    private PlanModuleRepositoryInterface $planModuleRepositoryInterfaceMock;
    private ModuleRepositoryInterface $moduleRepositoryInterfaceMock;
    private CompanyRepositoryInterface $companyRepositoryInterfaceMock;
    private CompanyPlanRepositoryInterface $companyPlanRepositoryInterfaceMock;
    private CompanyModuleRepositoryInterface $companyModuleRepositoryInterfaceMock;
    private GroupRepositoryInterface $groupRepositoryInterfaceMock;
    private ModulePermissionRepositoryInterface $modulePermissionRepositoryInterfaceMock;
    private GroupPermissionRepositoryInterface $groupPermissionRepositoryInterfaceMock;
    private UserRepositoryInterface $userRepositoryInterfaceMock;
    private ScheduleSettingsRepositoryInterface $scheduleSettingsRepositoryInterfaceMock;
    private JwtAuth $jwtAuthMock;

    private CreateCompanyAndAdminUser $useCase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->planRepositoryInterfaceMock = $this->createMock(PlanRepositoryInterface::class);
        $this->planModuleRepositoryInterfaceMock = $this->createMock(PlanModuleRepositoryInterface::class);
        $this->moduleRepositoryInterfaceMock = $this->createMock(ModuleRepositoryInterface::class);
        $this->companyRepositoryInterfaceMock = $this->createMock(CompanyRepositoryInterface::class);
        $this->companyPlanRepositoryInterfaceMock = $this->createMock(CompanyPlanRepositoryInterface::class);
        $this->companyModuleRepositoryInterfaceMock = $this->createMock(CompanyModuleRepositoryInterface::class);
        $this->groupRepositoryInterfaceMock = $this->createMock(GroupRepositoryInterface::class);
        $this->modulePermissionRepositoryInterfaceMock = $this->createMock(ModulePermissionRepositoryInterface::class);
        $this->groupPermissionRepositoryInterfaceMock = $this->createMock(GroupPermissionRepositoryInterface::class);
        $this->userRepositoryInterfaceMock = $this->createMock(UserRepositoryInterface::class);
        $this->scheduleSettingsRepositoryInterfaceMock = $this->createMock(ScheduleSettingsRepositoryInterface::class);
        $this->jwtAuthMock = $this->createMock(JwtAuth::class);

        $this->useCase = new CreateCompanyAndAdminUser(
            $this->planRepositoryInterfaceMock,
            $this->planModuleRepositoryInterfaceMock,
            $this->moduleRepositoryInterfaceMock,
            $this->companyRepositoryInterfaceMock,
            $this->companyPlanRepositoryInterfaceMock,
            $this->companyModuleRepositoryInterfaceMock,
            $this->groupRepositoryInterfaceMock,
            $this->modulePermissionRepositoryInterfaceMock,
            $this->groupPermissionRepositoryInterfaceMock,
            $this->userRepositoryInterfaceMock,
            $this->scheduleSettingsRepositoryInterfaceMock,
            $this->jwtAuthMock
        );
    }

    public function testValidateInputThrowsExceptionForEmptyFantasyName()
    {
        $this->expectException(CreateCompanyAndAdminUserException::class);
        $this->expectExceptionMessage('Nome fantasia é obrigatório');

        $input = new CreateCompanyAndAdminUserRequestDTO(
            1,
            [],
            '',
            'username',
            'name',
            'email',
            'phoneNumber',
            'password',
            [['day' => 'seg', 'start_time' => '08:00', 'end_time' => '17:00', 'is_working_day' => true]]
        );
        $this->useCase->execute($input);
    }

    public function testValidateInputThrowsExceptionForEmptyUsername()
    {
        $this->expectException(CreateCompanyAndAdminUserException::class);
        $this->expectExceptionMessage('Username é obrigatório');

        $input = new CreateCompanyAndAdminUserRequestDTO(
            1,
            [],
            'Fantasy Name',
            '',
            'name',
            'email',
            'phoneNumber',
            'password',
            [['day' => 'seg', 'start_time' => '08:00', 'end_time' => '17:00', 'is_working_day' => true]]
        );
        $this->useCase->execute($input);
    }

    public function testValidateInputThrowsExceptionForEmptyName()
    {
        $this->expectException(CreateCompanyAndAdminUserException::class);
        $this->expectExceptionMessage('Nome é obrigatório');

        $input = new CreateCompanyAndAdminUserRequestDTO(
            1,
            [],
            'Fantasy Name',
            'username',
            '',
            'email',
            'phoneNumber',
            'password',
            [['day' => 'seg', 'start_time' => '08:00', 'end_time' => '17:00', 'is_working_day' => true]]
        );
        $this->useCase->execute($input);
    }

    public function testValidateInputThrowsExceptionForEmptyEmail()
    {
        $this->expectException(CreateCompanyAndAdminUserException::class);
        $this->expectExceptionMessage('Email é obrigatório');

        $input = new CreateCompanyAndAdminUserRequestDTO(
            1,
            [],
            'Fantasy Name',
            'username',
            'name',
            '',
            'phoneNumber',
            'password',
            [['day' => 'seg', 'start_time' => '08:00', 'end_time' => '17:00', 'is_working_day' => true]]
        );
        $this->useCase->execute($input);
    }

    public function testValidateInputThrowsExceptionForEmptyPhoneNumber()
    {
        $this->expectException(CreateCompanyAndAdminUserException::class);
        $this->expectExceptionMessage('Telefone é obrigatório');

        $input = new CreateCompanyAndAdminUserRequestDTO(
            1,
            [],
            'Fantasy Name',
            'username',
            'name',
            'email',
            '',
            'password',
            [['day' => 'seg', 'start_time' => '08:00', 'end_time' => '17:00', 'is_working_day' => true]]
        );
        $this->useCase->execute($input);
    }

    public function testValidateInputThrowsExceptionForEmptyPassword()
    {
        $this->expectException(CreateCompanyAndAdminUserException::class);
        $this->expectExceptionMessage('Senha é obrigatório');

        $input = new CreateCompanyAndAdminUserRequestDTO(
            1,
            [],
            'Fantasy Name',
            'username',
            'name',
            'email',
            'phoneNumber',
            '',
            [['day' => 'seg', 'start_time' => '08:00', 'end_time' => '17:00', 'is_working_day' => true]]
        );
        $this->useCase->execute($input);
    }

    public function testValidateInputThrowsExceptionForEmptyWorkSchedule()
    {
        $this->expectException(CreateCompanyAndAdminUserException::class);
        $this->expectExceptionMessage('Horário de trabalho é obrigatório');

        $input = new CreateCompanyAndAdminUserRequestDTO(
            1,
            [],
            'Fantasy Name',
            'username',
            'name',
            'email',
            'phoneNumber',
            'password',
            []
        );
        $this->useCase->execute($input);
    }

    public function testPlanNotFound()
    {
        $this->expectException(CreateCompanyAndAdminUserException::class);
        $this->expectExceptionMessage('Plano não encontrado');

        $input = new CreateCompanyAndAdminUserRequestDTO(
            1,
            [],
            'Fantasy Name',
            'username',
            'name',
            'email',
            'phoneNumber',
            'password',
            [['day' => 'seg', 'start_time' => '08:00', 'end_time' => '17:00', 'is_working_day' => true]]
        );
        $this->planRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn(null);

        $this->useCase->execute($input);
    }

    public function testModuleNotFound()
    {
        $this->expectException(CreateCompanyAndAdminUserException::class);
        $this->expectExceptionMessage('Módulo não encontrado');

        $input = new CreateCompanyAndAdminUserRequestDTO(
            1,
            [1],
            'Fantasy Name',
            'username',
            'name',
            'email',
            'phoneNumber',
            'password',
            [['day' => 'seg', 'start_time' => '08:00', 'end_time' => '17:00', 'is_working_day' => true]]
        );

        $plan = new Plan();
        $plan->id = 1;

        $planModule = new \stdClass();
        $planModule->module_id = 1;

        $collection = new Collection([
            $planModule
        ]);

        $this->planRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn($plan);
        $this->planModuleRepositoryInterfaceMock->expects($this->once())->method('getByPlanId')->willReturn($collection);
        $this->moduleRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn(null);

        $this->useCase->execute($input);
    }


    public function testFantasyNameAlreadyExists()
    {
        $this->expectException(CreateCompanyAndAdminUserException::class);
        $this->expectExceptionMessage('Uma empresa com este nome já existe');

        $company = new Company();

        $input = new CreateCompanyAndAdminUserRequestDTO(
            1,
            [1],
            'Fantasy Name',
            'username',
            'name',
            'email',
            'phoneNumber',
            'password',
            [['day' => 'seg', 'start_time' => '08:00', 'end_time' => '17:00', 'is_working_day' => true]]
        );

        $plan = new Plan();
        $plan->id = 1;

        $planModule = new \stdClass();
        $planModule->module_id = 1;

        $collection = new Collection([
            $planModule
        ]);

        $module = new Module();
        $module->id = 1;

        $this->planRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn($plan);
        $this->planModuleRepositoryInterfaceMock->expects($this->once())->method('getByPlanId')->willReturn($collection);
        $this->moduleRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn($module);
        $this->companyRepositoryInterfaceMock->expects($this->once())->method('getByName')->willReturn($company);

        $this->useCase->execute($input);
    }

    public function testErrorSavingCompany()
    {
        $this->expectException(CreateCompanyAndAdminUserException::class);
        $this->expectExceptionMessage('Erro ao criar a empresa');

        $input = new CreateCompanyAndAdminUserRequestDTO(
            1,
            [1],
            'Fantasy Name',
            'username',
            'name',
            'email',
            'phoneNumber',
            'password',
            [['day' => 'seg', 'start_time' => '08:00', 'end_time' => '17:00', 'is_working_day' => true]]
        );

        $plan = new Plan();
        $plan->id = 1;

        $planModule = new \stdClass();
        $planModule->module_id = 1;

        $collection = new Collection([
            $planModule
        ]);

        $module = new Module();
        $module->id = 1;

        $this->planRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn($plan);
        $this->planModuleRepositoryInterfaceMock->expects($this->once())->method('getByPlanId')->willReturn($collection);
        $this->moduleRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn($module);
        $this->companyRepositoryInterfaceMock->expects($this->once())->method('getByName')->willReturn(null);
        $this->companyRepositoryInterfaceMock->expects($this->once())->method('save')->willReturn(false);

        $this->useCase->execute($input);
    }

    public function testErrorSavingCompanyPlan()
    {
        $this->expectException(CreateCompanyAndAdminUserException::class);
        $this->expectExceptionMessage('Erro ao salvar o plano na empresa');

        $input = new CreateCompanyAndAdminUserRequestDTO(
            1,
            [1],
            'Fantasy Name',
            'username',
            'name',
            'email',
            'phoneNumber',
            'password',
            [['day' => 'seg', 'start_time' => '08:00', 'end_time' => '17:00', 'is_working_day' => true]]
        );

        $plan = new Plan();
        $plan->id = 1;

        $planModule = new \stdClass();
        $planModule->module_id = 1;

        $collection = new Collection([
            $planModule
        ]);

        $module = new Module();
        $module->id = 1;

        $companyMock = $this->createMock(Company::class);

        $this->planRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn($plan);
        $this->planModuleRepositoryInterfaceMock->expects($this->once())->method('getByPlanId')->willReturn($collection);

        $this->moduleRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn($module);

        $this->companyRepositoryInterfaceMock->expects($this->once())->method('getByName')->willReturn(null);
        $this->companyRepositoryInterfaceMock->expects($this->once())->method('save')
            ->with($this->callback(function ($arg) use ($companyMock) {
                $arg->id = 1;
                return true;
            }))
            ->willReturn(true);

        $this->companyPlanRepositoryInterfaceMock->expects($this->once())->method('save')->willReturn(false);

        $this->useCase->execute($input);
    }

    public function testErrorSavingCompanyModule()
    {
        $this->expectException(CreateCompanyAndAdminUserException::class);
        $this->expectExceptionMessage('Erro ao salvar o módulo na empresa');

        $input = new CreateCompanyAndAdminUserRequestDTO(
            1,
            [1],
            'Fantasy Name',
            'username',
            'name',
            'email',
            'phoneNumber',
            'password',
            [['day' => 'seg', 'start_time' => '08:00', 'end_time' => '17:00', 'is_working_day' => true]]
        );

        $plan = new Plan();
        $plan->id = 1;

        $planModule = new \stdClass();
        $planModule->module_id = 1;

        $collection = new Collection([
            $planModule
        ]);

        $module = new Module();
        $module->id = 1;

        $companyMock = $this->createMock(Company::class);

        $this->planRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn($plan);
        $this->planModuleRepositoryInterfaceMock->expects($this->once())->method('getByPlanId')->willReturn($collection);

        $this->moduleRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn($module);

        $this->companyRepositoryInterfaceMock->expects($this->once())->method('getByName')->willReturn(null);
        $this->companyRepositoryInterfaceMock->expects($this->once())->method('save')
            ->with($this->callback(function ($arg) use ($companyMock) {
                $arg->id = 1;
                return true;
            }))
            ->willReturn(true);

        $this->companyPlanRepositoryInterfaceMock->expects($this->once())->method('save')->willReturn(true);
        $this->companyModuleRepositoryInterfaceMock->expects($this->once())->method('save')->willReturn(false);

        $this->useCase->execute($input);
    }

    public function testErrorSavingGroup()
    {
        $this->expectException(CreateCompanyAndAdminUserException::class);
        $this->expectExceptionMessage('Erro ao criar o grupo');

        $input = new CreateCompanyAndAdminUserRequestDTO(
            1,
            [1],
            'Fantasy Name',
            'username',
            'name',
            'email',
            'phoneNumber',
            'password',
            [['day' => 'seg', 'start_time' => '08:00', 'end_time' => '17:00', 'is_working_day' => true]]
        );

        $plan = new Plan();
        $plan->id = 1;

        $planModule = new \stdClass();
        $planModule->module_id = 1;

        $collection = new Collection([
            $planModule
        ]);

        $module = new Module();
        $module->id = 1;

        $companyMock = $this->createMock(Company::class);

        $this->planRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn($plan);
        $this->planModuleRepositoryInterfaceMock->expects($this->once())->method('getByPlanId')->willReturn($collection);

        $this->moduleRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn($module);

        $this->companyRepositoryInterfaceMock->expects($this->once())->method('getByName')->willReturn(null);
        $this->companyRepositoryInterfaceMock->expects($this->once())->method('save')
            ->with($this->callback(function ($arg) use ($companyMock) {
                $arg->id = 1;
                return true;
            }))
            ->willReturn(true);

        $this->companyPlanRepositoryInterfaceMock->expects($this->once())->method('save')->willReturn(true);
        $this->companyModuleRepositoryInterfaceMock->expects($this->once())->method('save')->willReturn(true);

        $this->groupRepositoryInterfaceMock->expects($this->once())->method('save')->willReturn(false);

        $this->useCase->execute($input);
    }

    public function testEmailAlreadyExists()
    {
        $this->expectException(CreateCompanyAndAdminUserException::class);
        $this->expectExceptionMessage('Email já cadastrado');

        $input = new CreateCompanyAndAdminUserRequestDTO(
            1,
            [1],
            'Fantasy Name',
            'username',
            'name',
            'email',
            'phoneNumber',
            'password',
            [['day' => 'seg', 'start_time' => '08:00', 'end_time' => '17:00', 'is_working_day' => true]]
        );

        $plan = new Plan();
        $plan->id = 1;

        $planModule = new \stdClass();
        $planModule->module_id = 1;

        $collection = new Collection([
            $planModule
        ]);

        $module = new Module();
        $module->id = 1;

        $companyMock = $this->createMock(Company::class);

        $this->planRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn($plan);
        $this->planModuleRepositoryInterfaceMock->expects($this->once())->method('getByPlanId')->willReturn($collection);

        $this->moduleRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn($module);

        $this->companyRepositoryInterfaceMock->expects($this->once())->method('getByName')->willReturn(null);
        $this->companyRepositoryInterfaceMock->expects($this->once())->method('save')
            ->with($this->callback(function ($arg) use ($companyMock) {
                $arg->id = 1;
                return true;
            }))
            ->willReturn(true);

        $this->companyPlanRepositoryInterfaceMock->expects($this->once())->method('save')->willReturn(true);
        $this->companyModuleRepositoryInterfaceMock->expects($this->once())->method('save')->willReturn(true);

        $this->groupRepositoryInterfaceMock->expects($this->once())->method('save')->willReturn(true);

        $user = new User();;

        $this->userRepositoryInterfaceMock->expects($this->once())->method('getByEmailAndCompanyId')->willReturn($user);

        $this->useCase->execute($input);
    }

    public function testUsernameAlreadyExists()
    {
        $this->expectException(CreateCompanyAndAdminUserException::class);
        $this->expectExceptionMessage('Nome de usuário já cadastrado');

        $input = new CreateCompanyAndAdminUserRequestDTO(
            1,
            [1],
            'Fantasy Name',
            'username',
            'name',
            'email',
            'phoneNumber',
            'password',
            [['day' => 'seg', 'start_time' => '08:00', 'end_time' => '17:00', 'is_working_day' => true]]
        );

        $plan = new Plan();
        $plan->id = 1;

        $this->planRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn($plan);

        $planModule = new \stdClass();
        $planModule->module_id = 1;

        $collection = new Collection([
            $planModule
        ]);

        $this->planModuleRepositoryInterfaceMock->expects($this->once())->method('getByPlanId')->willReturn($collection);

        $module = new Module();
        $module->id = 1;

        $this->moduleRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn($module);

        $this->companyRepositoryInterfaceMock->expects($this->once())->method('getByName')->willReturn(null);

        $companyMock = $this->createMock(Company::class);
        $this->companyRepositoryInterfaceMock->expects($this->once())->method('save')
            ->with($this->callback(function ($arg) use ($companyMock) {
                $arg->id = 1;
                return true;
            }))
            ->willReturn(true);

        $this->companyPlanRepositoryInterfaceMock->expects($this->once())->method('save')->willReturn(true);
        $this->companyModuleRepositoryInterfaceMock->expects($this->once())->method('save')->willReturn(true);

        $this->groupRepositoryInterfaceMock->expects($this->once())->method('save')->willReturn(true);

        $this->userRepositoryInterfaceMock->expects($this->once())->method('getByEmailAndCompanyId')->willReturn(null);

        $user = new User();

        $this->userRepositoryInterfaceMock->expects($this->once())->method('getByUsername')->willReturn($user);

        $this->useCase->execute($input);
    }

    public function testErrorSavingUser()
    {
        $this->expectException(CreateCompanyAndAdminUserException::class);
        $this->expectExceptionMessage('Erro ao criar o usuário');

        $input = new CreateCompanyAndAdminUserRequestDTO(
            1,
            [1],
            'Fantasy Name',
            'username',
            'name',
            'email',
            'phoneNumber',
            'password',
            [['day' => 'seg', 'start_time' => '08:00', 'end_time' => '17:00', 'is_working_day' => true]]
        );

        $plan = new Plan();
        $plan->id = 1;

        $this->planRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn($plan);

        $planModule = new \stdClass();
        $planModule->module_id = 1;

        $collection = new Collection([
            $planModule
        ]);

        $this->planModuleRepositoryInterfaceMock->expects($this->once())->method('getByPlanId')->willReturn($collection);

        $module = new Module();
        $module->id = 1;

        $this->moduleRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn($module);

        $this->companyRepositoryInterfaceMock->expects($this->once())->method('getByName')->willReturn(null);

        $companyMock = $this->createMock(Company::class);
        $this->companyRepositoryInterfaceMock->expects($this->once())->method('save')
            ->with($this->callback(function ($arg) use ($companyMock) {
                $arg->id = 1;
                return true;
            }))
            ->willReturn(true);

        $this->companyPlanRepositoryInterfaceMock->expects($this->once())->method('save')->willReturn(true);
        $this->companyModuleRepositoryInterfaceMock->expects($this->once())->method('save')->willReturn(true);

        $this->groupRepositoryInterfaceMock->expects($this->once())->method('save')->willReturn(true);

        $this->userRepositoryInterfaceMock->expects($this->once())->method('getByEmailAndCompanyId')->willReturn(null);

        $this->userRepositoryInterfaceMock->expects($this->once())->method('getByUsername')->willReturn(null);
        $this->userRepositoryInterfaceMock->expects($this->once())->method('save')->willReturn(false);

        $this->useCase->execute($input);
    }

    public function testInvalidWorkDay()
    {
        $this->expectException(CreateCompanyAndAdminUserException::class);
        $this->expectExceptionMessage('Dia de trabalho inválido.');

        $input = new CreateCompanyAndAdminUserRequestDTO(
            1,
            [1],
            'Fantasy Name',
            'username',
            'name',
            'email',
            'phoneNumber',
            'password',
            [['day' => 'wew', 'start_time' => '08:00', 'end_time' => '17:00', 'is_working_day' => true]]
        );

        $plan = new Plan();
        $plan->id = 1;

        $this->planRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn($plan);

        $planModule = new \stdClass();
        $planModule->module_id = 1;

        $collection = new Collection([
            $planModule
        ]);

        $this->planModuleRepositoryInterfaceMock->expects($this->once())->method('getByPlanId')->willReturn($collection);

        $module = new Module();
        $module->id = 1;

        $this->moduleRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn($module);

        $this->companyRepositoryInterfaceMock->expects($this->once())->method('getByName')->willReturn(null);

        $companyMock = $this->createMock(Company::class);
        $this->companyRepositoryInterfaceMock->expects($this->once())->method('save')
            ->with($this->callback(function ($arg) use ($companyMock) {
                $arg->id = 1;
                return true;
            }))
            ->willReturn(true);

        $this->companyPlanRepositoryInterfaceMock->expects($this->once())->method('save')->willReturn(true);
        $this->companyModuleRepositoryInterfaceMock->expects($this->once())->method('save')->willReturn(true);

        $this->groupRepositoryInterfaceMock->expects($this->once())->method('save')->willReturn(true);

        $this->userRepositoryInterfaceMock->expects($this->once())->method('getByEmailAndCompanyId')->willReturn(null);

        $this->userRepositoryInterfaceMock->expects($this->once())->method('getByUsername')->willReturn(null);

        $userMock = $this->createMock(User::class);
        $this->userRepositoryInterfaceMock->expects($this->once())->method('save')
            ->with($this->callback(function ($arg) use ($userMock) {
                $arg->id = 1;
                return true;
            }))->willReturn(true);

        $this->useCase->execute($input);
    }

    public function testErrorSavingScheduleSettings()
    {
        $this->expectException(CreateCompanyAndAdminUserException::class);
        $this->expectExceptionMessage('Erro ao salvar configuração de agenda.');

        $input = new CreateCompanyAndAdminUserRequestDTO(
            1,
            [1],
            'Fantasy Name',
            'username',
            'name',
            'email',
            'phoneNumber',
            'password',
            [['day' => 'seg', 'start_time' => '08:00', 'end_time' => '17:00', 'is_working_day' => true]]
        );

        $plan = new Plan();
        $plan->id = 1;

        $this->planRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn($plan);

        $planModule = new \stdClass();
        $planModule->module_id = 1;

        $collection = new Collection([
            $planModule
        ]);

        $this->planModuleRepositoryInterfaceMock->expects($this->once())->method('getByPlanId')->willReturn($collection);

        $module = new Module();
        $module->id = 1;

        $this->moduleRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn($module);

        $this->companyRepositoryInterfaceMock->expects($this->once())->method('getByName')->willReturn(null);

        $companyMock = $this->createMock(Company::class);
        $this->companyRepositoryInterfaceMock->expects($this->once())->method('save')
            ->with($this->callback(function ($arg) use ($companyMock) {
                $arg->id = 1;
                return true;
            }))
            ->willReturn(true);

        $this->companyPlanRepositoryInterfaceMock->expects($this->once())->method('save')->willReturn(true);
        $this->companyModuleRepositoryInterfaceMock->expects($this->once())->method('save')->willReturn(true);

        $this->groupRepositoryInterfaceMock->expects($this->once())->method('save')->willReturn(true);

        $this->userRepositoryInterfaceMock->expects($this->once())->method('getByEmailAndCompanyId')->willReturn(null);

        $this->userRepositoryInterfaceMock->expects($this->once())->method('getByUsername')->willReturn(null);

        $userMock = $this->createMock(User::class);
        $this->userRepositoryInterfaceMock->expects($this->once())->method('save')
            ->with($this->callback(function ($arg) use ($userMock) {
                $arg->id = 1;
                return true;
            }))->willReturn(true);

        $this->scheduleSettingsRepositoryInterfaceMock->expects($this->once())->method('save')->willReturn(false);

        $this->useCase->execute($input);
    }

    public function testErrorConfigJwt()
    {
        $this->expectException(CreateCompanyAndAdminUserException::class);
        $this->expectExceptionMessage('Configuração JWT inválida: verifique se "secret", "domain" e "expirationTime" estão definidos.');

        $input = new CreateCompanyAndAdminUserRequestDTO(
            1,
            [1],
            'Fantasy Name',
            'username',
            'name',
            'email',
            'phoneNumber',
            'password',
            [['day' => 'seg', 'start_time' => '08:00', 'end_time' => '17:00', 'is_working_day' => true]]
        );

        $plan = new Plan();
        $plan->id = 1;

        $this->planRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn($plan);

        $planModule = new \stdClass();
        $planModule->module_id = 1;

        $collection = new Collection([
            $planModule
        ]);

        $this->planModuleRepositoryInterfaceMock->expects($this->once())->method('getByPlanId')->willReturn($collection);

        $module = new Module();
        $module->id = 1;

        $this->moduleRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn($module);

        $this->companyRepositoryInterfaceMock->expects($this->once())->method('getByName')->willReturn(null);

        $companyMock = $this->createMock(Company::class);
        $this->companyRepositoryInterfaceMock->expects($this->once())->method('save')
            ->with($this->callback(function ($arg) use ($companyMock) {
                $arg->id = 1;
                return true;
            }))
            ->willReturn(true);

        $this->companyPlanRepositoryInterfaceMock->expects($this->once())->method('save')->willReturn(true);
        $this->companyModuleRepositoryInterfaceMock->expects($this->once())->method('save')->willReturn(true);

        $this->groupRepositoryInterfaceMock->expects($this->once())->method('save')->willReturn(true);

        $this->userRepositoryInterfaceMock->expects($this->once())->method('getByEmailAndCompanyId')->willReturn(null);

        $this->userRepositoryInterfaceMock->expects($this->once())->method('getByUsername')->willReturn(null);

        $userMock = $this->createMock(User::class);
        $this->userRepositoryInterfaceMock->expects($this->once())->method('save')
            ->with($this->callback(function ($arg) use ($userMock) {
                $arg->id = 1;
                return true;
            }))->willReturn(true);

        $this->scheduleSettingsRepositoryInterfaceMock->expects($this->once())->method('save')->willReturn(true);

        Config::set('jwtAuth.secret', null);
        Config::set('jwtAuth.domain', null);
        Config::set('jwtAuth.expirationTime', null);

        $this->useCase->execute($input);
    }

    public function testSuccess()
    {

        $input = new CreateCompanyAndAdminUserRequestDTO(
            1,
            [1],
            'Fantasy Name',
            'username',
            'name',
            'email',
            'phoneNumber',
            'password',
            [['day' => 'seg', 'start_time' => '08:00', 'end_time' => '17:00', 'is_working_day' => true]]
        );

        $plan = new Plan();
        $plan->id = 1;

        $this->planRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn($plan);

        $planModule = new \stdClass();
        $planModule->module_id = 1;

        $collection = new Collection([
            $planModule
        ]);

        $this->planModuleRepositoryInterfaceMock->expects($this->once())->method('getByPlanId')->willReturn($collection);

        $module = new Module();
        $module->id = 1;

        $this->moduleRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn($module);

        $this->companyRepositoryInterfaceMock->expects($this->once())->method('getByName')->willReturn(null);

        $companyMock = $this->createMock(Company::class);
        $this->companyRepositoryInterfaceMock->expects($this->once())->method('save')
            ->with($this->callback(function ($arg) use ($companyMock) {
                $arg->id = 1;
                return true;
            }))
            ->willReturn(true);

        $this->companyPlanRepositoryInterfaceMock->expects($this->once())->method('save')->willReturn(true);
        $this->companyModuleRepositoryInterfaceMock->expects($this->once())->method('save')->willReturn(true);

        $this->groupRepositoryInterfaceMock->expects($this->once())->method('save')->willReturn(true);

        $this->userRepositoryInterfaceMock->expects($this->once())->method('getByEmailAndCompanyId')->willReturn(null);

        $this->userRepositoryInterfaceMock->expects($this->once())->method('getByUsername')->willReturn(null);

        $userMock = $this->createMock(User::class);
        $this->userRepositoryInterfaceMock->expects($this->once())->method('save')
            ->with($this->callback(function ($arg) use ($userMock) {
                $arg->id = 1;
                return true;
            }))->willReturn(true);

        $this->scheduleSettingsRepositoryInterfaceMock->expects($this->once())->method('save')->willReturn(true);

        $this->jwtAuthMock->expects($this->once())->method('encode')->willReturn('jwtToken');

        $result = $this->useCase->execute($input);

        $this->assertIsArray($result);
        $this->assertArrayHasKey('company', $result);
        $this->assertArrayHasKey('token', $result);
        $this->assertArrayHasKey('user', $result);
        $this->assertEquals('jwtToken', $result['token']);
    }
}
