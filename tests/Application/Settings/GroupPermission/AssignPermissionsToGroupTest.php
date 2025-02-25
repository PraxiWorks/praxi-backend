<?php

namespace Tests\Application\Settings\GroupPermission;

use App\Application\Settings\GroupPermission\AssignPermissionsToGroup;
use App\Application\Settings\GroupPermission\DTO\AssignPermissionsToGroupRequestDTO;
use App\Domain\Exceptions\Core\Permission\PermissionNotFoundException;
use App\Domain\Exceptions\Settings\Group\GroupPermissionException;
use App\Domain\Interfaces\Core\Permission\PermissionRepositoryInterface;
use App\Domain\Interfaces\Settings\GroupPermission\GroupPermissionRepositoryInterface;
use App\Models\Core\Permission\Permission;
use Tests\TestCase;

class AssignPermissionsToGroupTest extends TestCase
{
    private PermissionRepositoryInterface $permissionRepositoryInterfaceMock;
    private GroupPermissionRepositoryInterface $groupPermissionRepositoryInterfaceMock;

    private AssignPermissionsToGroup $useCase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->permissionRepositoryInterfaceMock = $this->createMock(PermissionRepositoryInterface::class);
        $this->groupPermissionRepositoryInterfaceMock = $this->createMock(GroupPermissionRepositoryInterface::class);

        $this->useCase = new AssignPermissionsToGroup(
            $this->permissionRepositoryInterfaceMock,
            $this->groupPermissionRepositoryInterfaceMock
        );
    }


    public function testPermissionNotFound()
    {
        $this->expectException(PermissionNotFoundException::class);
        $this->expectExceptionMessage('Permissão não encontrada');

        $input = new AssignPermissionsToGroupRequestDTO(1, [1]);
        $this->permissionRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn(null);

        $this->useCase->execute($input);
    }

    public function testErrorAssignPermissions()
    {
        $this->expectException(GroupPermissionException::class);
        $this->expectExceptionMessage('Erro ao salvar permissão');

        $permission = new Permission();
        $permission->id = 1;
        
        $input = new AssignPermissionsToGroupRequestDTO(1, [1]);
        $this->permissionRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn($permission);
        $this->groupPermissionRepositoryInterfaceMock->expects($this->once())->method('save')->willReturn(false);

        $this->useCase->execute($input);
    }

    public function testSuccess()
    {

        $permission = new Permission();
        $permission->id = 1;

        $input = new AssignPermissionsToGroupRequestDTO(1, [1]);
        $this->permissionRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn($permission);
        $this->groupPermissionRepositoryInterfaceMock->expects($this->once())->method('save')->willReturn(true);

        $this->useCase->execute($input);

        $this->assertTrue(true);
    }
}
