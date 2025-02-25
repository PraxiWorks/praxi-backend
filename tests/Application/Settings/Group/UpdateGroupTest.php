<?php

namespace Tests\Application\Settings\Group;

use App\Application\Settings\Group\DTO\UpdateGroupRequestDTO;
use App\Application\Settings\Group\UpdateGroup;
use App\Domain\Exceptions\Settings\Group\GroupException;
use App\Domain\Exceptions\Settings\Group\GroupNotFoundException;
use App\Domain\Interfaces\Settings\Group\GroupRepositoryInterface;
use App\Models\Settings\Group\Group;
use Tests\TestCase;

class UpdateGroupTest extends TestCase
{
    private GroupRepositoryInterface $groupRepositoryInterfaceMock;

    private UpdateGroup $useCase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->groupRepositoryInterfaceMock = $this->createMock(GroupRepositoryInterface::class);

        $this->useCase = new UpdateGroup(
            $this->groupRepositoryInterfaceMock
        );
    }

    public function testValidateInputThrowsExceptionForEmptyName()
    {
        $this->expectException(GroupException::class);
        $this->expectExceptionMessage('Nome não informado');

        $input = new UpdateGroupRequestDTO(1, 1, '', true);
        $this->useCase->execute($input);
    }


    public function testGroupNotFound()
    {
        $this->expectException(GroupNotFoundException::class);

        $input = new UpdateGroupRequestDTO(1, 1, 'name', true);

        $this->groupRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn(null);

        $this->useCase->execute($input);
    }

    public function testGroupAlreadyExists()
    {
        $this->expectException(GroupException::class);
        $this->expectExceptionMessage('Já existe um grupo com esse nome');

        $input = new UpdateGroupRequestDTO(1, 1, 'name', 1);

        $groupMock = new Group();
        $groupMock->name = 'namee';

        $this->groupRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn($groupMock);
        $this->groupRepositoryInterfaceMock->expects($this->once())->method('findByNameAndCompanyId')->willReturn($groupMock);

        $this->useCase->execute($input);
    }

    public function testErrorUpdatingGroup()
    {
        $this->expectException(GroupException::class);
        $this->expectExceptionMessage('Erro ao atualizar o grupo');

        $input = new UpdateGroupRequestDTO(1, 1, 'name', true);

        $groupMock = new Group();
        $this->groupRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn($groupMock);
        $this->groupRepositoryInterfaceMock->expects($this->once())->method('update')->willReturn(false);

        $this->useCase->execute($input);

        $this->useCase->execute($input);
    }

    public function testSuccess()
    {
        $input = new UpdateGroupRequestDTO(1, 1, 'name', true);

        $groupMock = new Group();
        $this->groupRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn($groupMock);
        $this->groupRepositoryInterfaceMock->expects($this->once())->method('update')->willReturn(true);

        $result = $this->useCase->execute($input);
        $this->assertTrue($result);
    }
}
