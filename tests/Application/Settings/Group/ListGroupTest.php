<?php

namespace Tests\Application\Settings\Group;

use App\Application\DTO\IdRequestDTO;
use App\Application\Settings\Group\ListGroup;
use App\Domain\Interfaces\Settings\Group\GroupRepositoryInterface;
use Tests\TestCase;

class ListGroupTest extends TestCase
{
    private GroupRepositoryInterface $groupRepositoryInterfaceMock;

    private ListGroup $useCase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->groupRepositoryInterfaceMock = $this->createMock(GroupRepositoryInterface::class);

        $this->useCase = new ListGroup(
            $this->groupRepositoryInterfaceMock
        );
    }

    public function testExecuteReturnsExpectedGroupList()
    {
        // Define o valor de retorno esperado do método list
        $groups = $this->groupsMock();

        $input = new IdRequestDTO(1);
        $this->groupRepositoryInterfaceMock->expects($this->once())->method('list')->willReturn($groups);

        $result = $this->useCase->execute($input);

        // Verifica se o resultado é o esperado
        $this->assertEquals($groups, $result);
    }

    public function groupsMock()
    {
        return [
            [
                "id" => 1,
                "company_id" => 1,
                "name" => "Example Group",
                "status" => true,
                "created_at" => "2024-12-22T22:38:44.000000Z",
                "updated_at" => "2024-12-22T22:38:44.000000Z"
            ]
        ];
    }
}
