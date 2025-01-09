<?php

namespace Tests\Application\Settings\Group;

use App\Application\Settings\Group\CreateGroup;
use App\Application\Settings\Group\DTO\CreateGroupRequestDTO;
use App\Domain\Exceptions\Settings\Group\GroupException;
use App\Domain\Interfaces\Settings\Group\GroupRepositoryInterface;
use App\Models\Settings\Group\Group;
use Tests\TestCase;

class CreateGroupTest extends TestCase
{
    private GroupRepositoryInterface $groupRepositoryInterfaceMock;

    private CreateGroup $useCase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->groupRepositoryInterfaceMock = $this->createMock(GroupRepositoryInterface::class);

        $this->useCase = new CreateGroup(
            $this->groupRepositoryInterfaceMock
        );
    }

    public function testValidateInputThrowsExceptionForEmptyName()
    {
        $this->expectException(GroupException::class);
        $this->expectExceptionMessage('Nome não informado');

        $input = new CreateGroupRequestDTO(1, '', 1);
        $this->useCase->execute($input);
    }


    public function testGroupAlreadyExists()
    {
        $this->expectException(GroupException::class);
        $this->expectExceptionMessage('Grupo já cadastrado');

        $input = new CreateGroupRequestDTO(1, 'name', 1);

        $groupMock = new Group();
        $this->groupRepositoryInterfaceMock->expects($this->once())->method('findByNameAndCompanyId')->willReturn($groupMock);

        $this->useCase->execute($input);
    }

    public function testErrorSavingGroup()
    {
        $this->expectException(GroupException::class);
        $this->expectExceptionMessage('Erro ao salvar o grupo');

        $input = new CreateGroupRequestDTO(1, 'name', 1);

        $this->groupRepositoryInterfaceMock->expects($this->once())->method('findByNameAndCompanyId')->willReturn(null);
        $this->groupRepositoryInterfaceMock->expects($this->once())->method('save')->willReturn(false);

        $this->useCase->execute($input);
    }

    public function testSuccess()
    {
        $input = new CreateGroupRequestDTO(1, 'name', 1);

        $this->groupRepositoryInterfaceMock->expects($this->once())->method('findByNameAndCompanyId')->willReturn(null);
        $this->groupRepositoryInterfaceMock->expects($this->once())->method('save')->willReturn(true);

        $result = $this->useCase->execute($input);
        $this->assertTrue($result);
    }
}
