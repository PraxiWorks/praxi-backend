<?php

namespace Tests\Application\User;

use App\Application\User\DTO\UpdateUserRequestDTO;
use App\Application\User\UpdateUser;
use App\Domain\Exceptions\User\UserException;
use App\Domain\Exceptions\User\UserNotFoundException;
use App\Domain\Interfaces\User\UserRepositoryInterface;
use App\Models\User\User;
use Tests\TestCase;

class UpdateUserTest extends TestCase
{
    private UserRepositoryInterface $userRepositoryInterfaceMock;

    private UpdateUser $useCase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->userRepositoryInterfaceMock = $this->createMock(UserRepositoryInterface::class);

        $this->useCase = new UpdateUser(
            $this->userRepositoryInterfaceMock
        );
    }

    public function testValidateInputThrowsExceptionForEmptyName()
    {
        $this->expectException(UserException::class);
        $this->expectExceptionMessage('Nome não informado');

        $input = new UpdateUserRequestDTO(1, 1, '', 'email', 'phoneNumber', 1, 'dateOfBirth', 'cpfNumber', 'rgNumber', 'gender', false, false, false, null, true);
        $this->useCase->execute($input);
    }

    public function testValidateInputThrowsExceptionForEmptyEmail()
    {
        $this->expectException(UserException::class);
        $this->expectExceptionMessage('Email não informado');

        $input = new UpdateUserRequestDTO(1, 1, 'nome', '', 'phoneNumber', 1, 'dateOfBirth', 'cpfNumber', 'rgNumber', 'gender', false, false, false, null, true);
        $this->useCase->execute($input);
    }

    public function testValidateInputThrowsExceptionForEmptyTypeId()
    {
        $this->expectException(UserException::class);
        $this->expectExceptionMessage('Tipo de usuário não informado');

        $input = new UpdateUserRequestDTO(1, 1, 'nome', 'email', 'phoneNumber', 0, 'dateOfBirth', 'cpfNumber', 'rgNumber', 'gender', false, false, false, null, true);
        $this->useCase->execute($input);
    }

    public function testUserNotFound()
    {
        $this->expectException(UserNotFoundException::class);
        $this->expectExceptionMessage('Usuário não encontrado');

        $input = new UpdateUserRequestDTO(1, 1, 'nome', 'email', 'phoneNumber', 1, 'dateOfBirth', 'cpfNumber', 'rgNumber', 'gender', false, false, false, null, true);
        $this->userRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn(null);

        $this->useCase->execute($input);
    }

    public function testErrorSavingUser()
    {
        $this->expectException(UserException::class);
        $this->expectExceptionMessage('Erro ao atualizar usuário');

        $user = new User();

        $input = new UpdateUserRequestDTO(1, 1, 'nome', 'email', 'phoneNumber', 1, 'dateOfBirth', 'cpfNumber', 'rgNumber', 'gender', false, false, false, null, true);
        $this->userRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn($user);
        $this->userRepositoryInterfaceMock->expects($this->once())->method('update')->willReturn(false);

        $this->useCase->execute($input);
    }

    public function testSuccess()
    {
        $user = new User();

        $input = new UpdateUserRequestDTO(1, 1, 'nome', 'email', 'phoneNumber', 1, 'dateOfBirth', 'cpfNumber', 'rgNumber', 'gender', false, false, false, null, true);
        $this->userRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn($user);
        $this->userRepositoryInterfaceMock->expects($this->once())->method('update')->willReturn(true);

        $this->useCase->execute($input);

        $this->assertTrue(true);
    }
}
