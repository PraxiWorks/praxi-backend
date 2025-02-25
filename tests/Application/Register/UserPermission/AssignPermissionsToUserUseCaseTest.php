<?php

namespace Tests\Application\Register\UserPermission;

use App\Application\Register\UserPermission\AssignPermissionsToUserUseCase;
use App\Application\Register\UserPermission\DTO\AssignPermissionsToUserRequestDTO;
use App\Domain\Exceptions\Core\Permission\PermissionNotFoundException;
use App\Domain\Exceptions\Register\User\Permission\UserPermissionException;
use App\Domain\Interfaces\Core\Permission\PermissionRepositoryInterface;
use App\Domain\Interfaces\Register\UserPermission\UserPermissionRepositoryInterface;
use App\Models\Core\Permission\Permission;
use Tests\TestCase;

class AssignPermissionsToUserUseCaseTest extends TestCase
{
    private PermissionRepositoryInterface $permissionRepositoryInterfaceMock;
    private UserPermissionRepositoryInterface $userPermissionRepositoryInterfaceMock;

    private AssignPermissionsToUserUseCase $useCase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->permissionRepositoryInterfaceMock = $this->createMock(PermissionRepositoryInterface::class);
        $this->userPermissionRepositoryInterfaceMock = $this->createMock(UserPermissionRepositoryInterface::class);

        $this->useCase = new AssignPermissionsToUserUseCase(
            $this->permissionRepositoryInterfaceMock,
            $this->userPermissionRepositoryInterfaceMock
        );
    }


    public function testPermissionNotFound()
    {
        $this->expectException(PermissionNotFoundException::class);
        $this->expectExceptionMessage('Permissão não encontrada');

        $input = new AssignPermissionsToUserRequestDTO(1, [1]);
        $this->permissionRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn(null);

        $this->useCase->execute($input);
    }

    public function testErrorAssignPermissions()
    {
        $this->expectException(UserPermissionException::class);
        $this->expectExceptionMessage('Erro ao salvar permissão');

        $permission = new Permission();
        $permission->id = 1;
        
        $input = new AssignPermissionsToUserRequestDTO(1, [1]);
        $this->permissionRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn($permission);
        $this->userPermissionRepositoryInterfaceMock->expects($this->once())->method('save')->willReturn(false);

        $this->useCase->execute($input);
    }

    public function testSuccess()
    {

        $permission = new Permission();
        $permission->id = 1;

        $input = new AssignPermissionsToUserRequestDTO(1, [1]);
        $this->permissionRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn($permission);
        $this->userPermissionRepositoryInterfaceMock->expects($this->once())->method('save')->willReturn(true);

        $this->useCase->execute($input);

        $this->assertTrue(true);
    }
}
