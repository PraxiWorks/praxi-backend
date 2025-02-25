<?php

namespace Tests\Application\Settings\GroupPermission;

use App\Application\DTO\IdRequestDTO;
use App\Application\Settings\GroupPermission\DeleteGroupPermission;
use App\Domain\Exceptions\Settings\Group\GroupException;
use App\Domain\Exceptions\Settings\Group\GroupNotFoundException;
use App\Domain\Interfaces\Settings\GroupPermission\GroupPermissionRepositoryInterface;
use Tests\TestCase;

class DeleteGroupPermissionTest extends TestCase
{
    private GroupPermissionRepositoryInterface $groupPermissionRepositoryInterfaceMock;

    private DeleteGroupPermission $useCase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->groupPermissionRepositoryInterfaceMock = $this->createMock(GroupPermissionRepositoryInterface::class);

        $this->useCase = new DeleteGroupPermission(
            $this->groupPermissionRepositoryInterfaceMock
        );
    }

    public function testGroupPermissionNotFound()
    {
        $this->expectException(GroupNotFoundException::class);
        $this->expectExceptionMessage('Permição do grupo não encontrado');

        $input = new IdRequestDTO(1);
        $this->groupPermissionRepositoryInterfaceMock->expects($this->once())->method('getByGroupId')->willReturn([]);

        $this->useCase->execute($input);
    }

    public function testErrorDeletePermissions()
    {
        $this->expectException(GroupException::class);
        $this->expectExceptionMessage('Erro ao deletar permissão do grupo');

        $groupPermission = [['id' => 1]];

        $input = new IdRequestDTO(1);
        $this->groupPermissionRepositoryInterfaceMock->expects($this->once())->method('getByGroupId')->willReturn($groupPermission);
        $this->groupPermissionRepositoryInterfaceMock->expects($this->once())->method('delete')->willReturn(false);

        $this->useCase->execute($input);
    }

    public function testSuccess()
    {

        $groupPermission = [['id' => 1]];

        $input = new IdRequestDTO(1);
        $this->groupPermissionRepositoryInterfaceMock->expects($this->once())->method('getByGroupId')->willReturn($groupPermission);
        $this->groupPermissionRepositoryInterfaceMock->expects($this->once())->method('delete')->willReturn(true);

        $this->useCase->execute($input);

        $this->assertTrue(true);
    }
}
