<?php

namespace Tests\Application\Register\UserPermission;

use App\Application\Register\UserPermission\DTO\UpdateUserPermissionRequestDTO;
use App\Application\Register\UserPermission\UpdateUserPermission;
use App\Domain\Exceptions\Core\Permission\PermissionNotFoundException;
use App\Domain\Exceptions\Register\User\Permission\UserPermissionException;
use App\Domain\Interfaces\Core\Permission\PermissionRepositoryInterface;
use App\Domain\Interfaces\Register\UserPermission\UserPermissionRepositoryInterface;
use App\Models\Core\Permission\Permission;
use Tests\TestCase;

class UpdateUserPermissionTest extends TestCase
{
    private PermissionRepositoryInterface $permissionRepositoryInterfaceMock;
    private UserPermissionRepositoryInterface $userPermissionRepositoryInterfaceMock;

    private UpdateUserPermission $useCase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->permissionRepositoryInterfaceMock = $this->createMock(PermissionRepositoryInterface::class);
        $this->userPermissionRepositoryInterfaceMock = $this->createMock(UserPermissionRepositoryInterface::class);

        $this->useCase = new UpdateUserPermission(
            $this->permissionRepositoryInterfaceMock,
            $this->userPermissionRepositoryInterfaceMock
        );
    }


    public function testPermissionNotFound()
    {
        $this->expectException(PermissionNotFoundException::class);
        $this->expectExceptionMessage('Permissão não encontrada');

        $input = new UpdateUserPermissionRequestDTO(1, [1, 3]);
        $this->userPermissionRepositoryInterfaceMock->expects($this->once())->method('getPermissionIdsByUserId')->willReturn([1, 2]);
        $this->userPermissionRepositoryInterfaceMock->expects($this->once())->method('deleteByUserIdAndPermissionIds')->willReturn(true);

        $this->permissionRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn(null);

        $this->useCase->execute($input);
    }

    public function testErrorSavePermissions()
    {
        $this->expectException(UserPermissionException::class);
        $this->expectExceptionMessage('Erro ao salvar permissão');

        $permission = new Permission();
        $permission->id = 1;

        $input = new UpdateUserPermissionRequestDTO(1, [1, 3]);
        $this->userPermissionRepositoryInterfaceMock->expects($this->once())->method('getPermissionIdsByUserId')->willReturn([1, 2]);
        $this->userPermissionRepositoryInterfaceMock->expects($this->once())->method('deleteByUserIdAndPermissionIds')->willReturn(true);

        $this->permissionRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn($permission);
        $this->userPermissionRepositoryInterfaceMock->expects($this->once())->method('save')->willReturn(false);

        $this->useCase->execute($input);
    }

    public function testSuccess()
    {

        $permission = new Permission();
        $permission->id = 1;

        $input = new UpdateUserPermissionRequestDTO(1, [1, 3]);
        $this->userPermissionRepositoryInterfaceMock->expects($this->once())->method('getPermissionIdsByUserId')->willReturn([1, 2]);
        $this->userPermissionRepositoryInterfaceMock->expects($this->once())->method('deleteByUserIdAndPermissionIds')->willReturn(true);

        $this->permissionRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn($permission);
        $this->userPermissionRepositoryInterfaceMock->expects($this->once())->method('save')->willReturn(true);

        $this->useCase->execute($input);

        $this->assertTrue(true);
    }
}
