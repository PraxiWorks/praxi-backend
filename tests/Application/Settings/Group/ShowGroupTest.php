<?php

namespace Tests\Application\Settings\Group;

use App\Application\DTO\IdRequestDTO;
use App\Application\Settings\Group\ShowGroup;
use App\Domain\Exceptions\Settings\Group\GroupNotFoundException;
use App\Domain\Interfaces\Settings\Group\GroupRepositoryInterface;
use App\Models\Settings\Group\Group;
use Tests\TestCase;

class ShowGroupTest extends TestCase
{
    private GroupRepositoryInterface $groupRepositoryInterfaceMock;

    private ShowGroup $useCase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->groupRepositoryInterfaceMock = $this->createMock(GroupRepositoryInterface::class);

        $this->useCase = new ShowGroup(
            $this->groupRepositoryInterfaceMock
        );
    }

    public function testGroupNotFound()
    {
        $this->expectException(GroupNotFoundException::class);

        $input = new IdRequestDTO(1);
        $this->groupRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn(null);

        $result = $this->useCase->execute($input);

        $this->assertNull($result);
    }

    public function testExecuteReturnsExpectedGroup()
    {
        // Define o valor de retorno esperado do método list
        $group = new Group();

        $input = new IdRequestDTO(1);
        $this->groupRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn($group);

        $result = $this->useCase->execute($input);

        // Verifica se o resultado é o esperado
        $this->assertEquals($group, $result);
    }
}
