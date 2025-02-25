<?php

namespace Tests\Application\Settings\GroupPermission;

use App\Application\DTO\IdRequestDTO;
use App\Application\Settings\GroupPermission\GetPermissionsGroup;
use App\Domain\Interfaces\Settings\GroupPermission\GroupPermissionRepositoryInterface;
use Tests\TestCase;

class GetPermissionsGroupTest extends TestCase
{
    private GroupPermissionRepositoryInterface $groupPermissionRepositoryInterfaceMock;

    private GetPermissionsGroup $useCase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->groupPermissionRepositoryInterfaceMock = $this->createMock(GroupPermissionRepositoryInterface::class);

        $this->useCase = new GetPermissionsGroup(
            $this->groupPermissionRepositoryInterfaceMock
        );
    }

    public function testSuccess()
    {
        $groupPermissions = [
            ['permission_id' => 1],
            ['permission_id' => 2],
            ['permission_id' => 3],
        ];

        $input = new IdRequestDTO(1);
        $this->groupPermissionRepositoryInterfaceMock->expects($this->once())->method('getByGroupId')->willReturn($groupPermissions);

        $permissions = $this->useCase->execute($input);

        $this->assertEquals([1, 2, 3], $permissions);
    }
}
