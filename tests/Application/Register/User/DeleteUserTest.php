<?php

namespace Tests\Application\Register\User;

use App\Application\DTO\IdRequestDTO;
use App\Application\Register\User\DeleteUser;
use App\Domain\Exceptions\Register\User\UserException;
use App\Domain\Exceptions\Register\User\UserNotFoundException;
use App\Domain\Interfaces\Register\User\UserRepositoryInterface;
use App\Models\Register\User\User;
use Tests\TestCase;

class DeleteUserTest extends TestCase
{
    private UserRepositoryInterface $userRepositoryInterfaceMock;

    private DeleteUser $useCase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->userRepositoryInterfaceMock = $this->createMock(UserRepositoryInterface::class);

        $this->useCase = new DeleteUser(
            $this->userRepositoryInterfaceMock
        );
    }

    public function testUserNotFound()
    {
        $this->expectException(UserNotFoundException::class);
        $this->expectExceptionMessage('Usuário não encontrado');

        $input = new IdRequestDTO(1);
        $this->userRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn(null);

        $this->useCase->execute($input);
    }

    public function testErrorDelteUser()
    {
        $this->expectException(UserException::class);
        $this->expectExceptionMessage('Erro ao deletar usuário');

        $user = new User();

        $input = new IdRequestDTO(1);
        $this->userRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn($user);
        $this->userRepositoryInterfaceMock->expects($this->once())->method('delete')->willReturn(false);

        $this->useCase->execute($input);
    }

    public function testSuccess()
    {
        $user = new User();

        $input = new IdRequestDTO(1);
        $this->userRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn($user);
        $this->userRepositoryInterfaceMock->expects($this->once())->method('delete')->willReturn(true);

        $this->useCase->execute($input);

        $this->assertTrue(true);
    }
}
