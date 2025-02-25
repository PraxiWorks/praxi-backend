<?php

namespace Tests\Application\Settings\Permission;

use App\Application\DTO\OutputArrayDTO;
use App\Application\Settings\Permission\DTO\ListPermissionsRequestDTO;
use App\Application\Settings\Permission\ListPermission;
use App\Application\Settings\Permission\Mapper\ListPermissionMapper;
use App\Domain\Interfaces\Core\Company\CompanyModuleRepositoryInterface;
use App\Domain\Interfaces\Core\Company\CompanyPlanRepositoryInterface;
use App\Domain\Interfaces\Core\Permission\ModulePermissionRepositoryInterface;
use App\Domain\Interfaces\Core\Permission\PermissionRepositoryInterface;
use App\Domain\Interfaces\Core\Plan\PlanModuleRepositoryInterface;
use App\Models\Core\Company\CompanyPlan;
use App\Models\Core\Permission\ModulePermission;
use App\Models\Core\Plan\PlanModule;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;

class ListPermissionTest extends TestCase
{
    private CompanyPlanRepositoryInterface $companyPlanRepositoryInterfaceMock;
    private CompanyModuleRepositoryInterface $companyModuleRepositoryInterfaceMock;
    private PlanModuleRepositoryInterface $planModuleRepositoryInterfaceMock;
    private ModulePermissionRepositoryInterface $modulePermissionRepositoryInterfaceMock;
    private PermissionRepositoryInterface $permissionRepositoryInterfaceMock;
    private ListPermissionMapper $listPermissionMapperMock;

    private ListPermission $useCase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->companyPlanRepositoryInterfaceMock = $this->createMock(CompanyPlanRepositoryInterface::class);
        $this->companyModuleRepositoryInterfaceMock = $this->createMock(CompanyModuleRepositoryInterface::class);
        $this->planModuleRepositoryInterfaceMock = $this->createMock(PlanModuleRepositoryInterface::class);
        $this->modulePermissionRepositoryInterfaceMock = $this->createMock(ModulePermissionRepositoryInterface::class);
        $this->permissionRepositoryInterfaceMock = $this->createMock(PermissionRepositoryInterface::class);
        $this->listPermissionMapperMock = $this->createMock(ListPermissionMapper::class);

        $this->useCase = new ListPermission(
            $this->companyPlanRepositoryInterfaceMock,
            $this->companyModuleRepositoryInterfaceMock,
            $this->planModuleRepositoryInterfaceMock,
            $this->modulePermissionRepositoryInterfaceMock,
            $this->permissionRepositoryInterfaceMock,
            $this->listPermissionMapperMock
        );
    }

    public function testExecuteReturnsExpectedPermissions()
    {
        // Define o valor de retorno esperado do método list
        $permissions = $this->permissionsMock();
        $outputDto = new OutputArrayDTO($permissions);

        $input = new ListPermissionsRequestDTO(1, [1, 2, 3]);
        $this->permissionRepositoryInterfaceMock->expects($this->once())->method('getPermissionsByIds')->willReturn($permissions);
        $this->listPermissionMapperMock->expects($this->once())->method('toOutputDto')->willReturn($outputDto);

        $result = $this->useCase->execute($input);

        // Verifica se o resultado é o esperado
        $this->assertEquals($outputDto, $result);
    }

    public function testExecuteReturnsExpectedPermissionsWhenPermissionsIsEmpty()
    {
        // Define o valor de retorno esperado do método list
        $permissions = $this->permissionsMock();
        $outputDto = new OutputArrayDTO($permissions);

        $companyPlan = new CompanyPlan();
        $companyPlan->id = 1;

        $modulePermissions = new Collection([new ModulePermission()]);

        $input = new ListPermissionsRequestDTO(1, []);
        $this->companyPlanRepositoryInterfaceMock->expects($this->once())->method('getByCompanyId')->willReturn($companyPlan);
        $this->companyModuleRepositoryInterfaceMock->expects($this->once())->method('getByCompanyId')->willReturn([['module_id' => 1]]);
        $planModulesMock = new PlanModule();
        $planModulesMock->module_id = 1;
        $planModules = new Collection([$planModulesMock]);
        $this->planModuleRepositoryInterfaceMock->expects($this->once())->method('getByPlanId')->willReturn($planModules);
        $this->modulePermissionRepositoryInterfaceMock->expects($this->once())->method('getPermissionsByList')->willReturn($modulePermissions);
        $this->permissionRepositoryInterfaceMock->expects($this->once())->method('getPermissionsByIds')->willReturn($permissions);
        $this->listPermissionMapperMock->expects($this->once())->method('toOutputDto')->willReturn($outputDto);

        $result = $this->useCase->execute($input);

        // Verifica se o resultado é o esperado
        $this->assertEquals($outputDto, $result);
    }

    public function permissionsMock()
    {
        return [
            [
                [
                    ['id' => 1, 'display_name' => 'View Users', 'name' => 'users.view'],
                    ['id' => 2, 'display_name' => 'Edit Users', 'name' => 'users.edit'],
                    ['id' => 3, 'display_name' => 'View Roles', 'name' => 'roles.view'],
                ]
            ]
        ];
    }
}
