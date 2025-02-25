<?php

namespace Tests\Application\Register\UserPermission;

use App\Application\Register\UserPermission\GetUserPermission;
use App\Application\DTO\IdRequestDTO;
use App\Domain\Exceptions\Register\User\UserNotFoundException;
use App\Domain\Interfaces\Register\UserPermission\UserPermissionRepositoryInterface;
use App\Infrastructure\Eloquent\Register\User\UserRepository;
use App\Models\Register\User\User;
use Tests\TestCase;

class GetUserPermissionTest extends TestCase
{
    private UserRepository $userRepositoryInterfaceMock;
    private UserPermissionRepositoryInterface $userPermissionRepositoryInterfaceMock;

    private GetUserPermission $useCase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->userRepositoryInterfaceMock = $this->createMock(UserRepository::class);
        $this->userPermissionRepositoryInterfaceMock = $this->createMock(UserPermissionRepositoryInterface::class);

        $this->useCase = new GetUserPermission(
            $this->userRepositoryInterfaceMock,
            $this->userPermissionRepositoryInterfaceMock
        );
    }

    public function testUserNotFound()
    {
        $this->expectException(UserNotFoundException::class);
        $this->expectExceptionMessage('User not found');

        $input = new IdRequestDTO(1);
        $this->userRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn(null);

        $this->useCase->execute($input);
    }

    public function testSuccess()
    {
        $user = new User();
        $user->id = 1;

        $userPermissions = [
            ['permission_id' => 1],
            ['permission_id' => 2],
            ['permission_id' => 3],
        ];

        $input = new IdRequestDTO(1);
        $this->userRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn($user);
        $this->userPermissionRepositoryInterfaceMock->expects($this->once())->method('getByUserId')->willReturn($userPermissions);

        $permissions = $this->useCase->execute($input);

        $this->assertEquals([1, 2, 3], $permissions);
    }
}
