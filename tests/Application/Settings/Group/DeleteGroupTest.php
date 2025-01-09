<?php

namespace Tests\Application\Settings\Group;

use App\Application\DTO\IdRequestDTO;
use App\Application\Settings\Group\DeleteGroup;
use App\Domain\Exceptions\Settings\Group\GroupException;
use App\Domain\Exceptions\Settings\Group\GroupNotFoundException;
use App\Domain\Interfaces\Settings\Group\GroupRepositoryInterface;
use App\Models\Settings\Group\Group;
use Tests\TestCase;

class DeleteGroupTest extends TestCase
{
    private GroupRepositoryInterface $groupRepositoryInterfaceMock;

    private DeleteGroup $useCase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->groupRepositoryInterfaceMock = $this->createMock(GroupRepositoryInterface::class);

        $this->useCase = new DeleteGroup(
            $this->groupRepositoryInterfaceMock
        );
    }

    public function testGroupNotFound()
    {
        $this->expectException(GroupNotFoundException::class);
        $this->expectExceptionMessage('Grupo não encontrado');

        $input = new IdRequestDTO(1);
        $this->groupRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn(null);

        $this->useCase->execute($input);
    }

    public function testErrorDelteGroup()
    {
        $this->expectException(GroupException::class);
        $this->expectExceptionMessage('Erro ao deletar grupo');

        $input = new IdRequestDTO(1);

        $group = new Group();

        $this->groupRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn($group);
        $this->groupRepositoryInterfaceMock->expects($this->once())->method('delete')->willReturn(false);

        $this->useCase->execute($input);
    }

    public function testSuccess()
    {
        $input = new IdRequestDTO(1);

        $group = new Group();

        $this->groupRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn($group);
        $this->groupRepositoryInterfaceMock->expects($this->once())->method('delete')->willReturn(true);

        $this->useCase->execute($input);

        $this->assertTrue(true);
    }
}
