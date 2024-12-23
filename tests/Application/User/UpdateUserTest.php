<?php

namespace Tests\Application\User;

use App\Application\User\DTO\UpdateUserRequestDTO;
use App\Application\User\UpdateUser;
use App\Domain\Exceptions\User\UserException;
use App\Domain\Exceptions\User\UserNotFoundException;
use App\Domain\Interfaces\Company\CompanyRepositoryInterface;
use App\Domain\Interfaces\User\UserRepositoryInterface;
use App\Models\Company\Company;
use App\Models\User\User;
use App\Services\Image\ProcessImage;
use Tests\TestCase;

class UpdateUserTest extends TestCase
{
    private UserRepositoryInterface $userRepositoryInterfaceMock;
    private CompanyRepositoryInterface $companyRepositoryInterfaceMock;
    private ProcessImage $processImageMock;

    private UpdateUser $useCase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->userRepositoryInterfaceMock = $this->createMock(UserRepositoryInterface::class);
        $this->companyRepositoryInterfaceMock = $this->createMock(CompanyRepositoryInterface::class);
        $this->processImageMock = $this->createMock(ProcessImage::class);

        $this->useCase = new UpdateUser(
            $this->userRepositoryInterfaceMock,
            $this->companyRepositoryInterfaceMock,
            $this->processImageMock
        );
    }

    public function testValidateInputThrowsExceptionForEmptyUsername()
    {
        $this->expectException(UserException::class);
        $this->expectExceptionMessage('Nome de usuário não informado');

        $input = new UpdateUserRequestDTO(1, 1, '', 'name', 'email', 'phoneNumber', 1, 'dateOfBirth', 'cpfNumber', 'rgNumber', 'gender', false, false, false, null, true);
        $this->useCase->execute($input);
    }

    public function testValidateInputThrowsExceptionForEmptyName()
    {
        $this->expectException(UserException::class);
        $this->expectExceptionMessage('Nome não informado');

        $input = new UpdateUserRequestDTO(1, 1, 'username', '', 'email', 'phoneNumber', 1, 'dateOfBirth', 'cpfNumber', 'rgNumber', 'gender', false, false, false, null, true);
        $this->useCase->execute($input);
    }

    public function testValidateInputThrowsExceptionForEmptyEmail()
    {
        $this->expectException(UserException::class);
        $this->expectExceptionMessage('Email não informado');

        $input = new UpdateUserRequestDTO(1, 1, 'username', 'nome', '', 'phoneNumber', 1, 'dateOfBirth', 'cpfNumber', 'rgNumber', 'gender', false, false, false, null, true);
        $this->useCase->execute($input);
    }

    public function testValidateInputThrowsExceptionForEmptyTypeId()
    {
        $this->expectException(UserException::class);
        $this->expectExceptionMessage('Tipo de usuário não informado');

        $input = new UpdateUserRequestDTO(1, 1, 'username', 'nome', 'email', 'phoneNumber', 0, 'dateOfBirth', 'cpfNumber', 'rgNumber', 'gender', false, false, false, null, true);
        $this->useCase->execute($input);
    }

    public function testUserNotFound()
    {
        $this->expectException(UserNotFoundException::class);
        $this->expectExceptionMessage('Usuário não encontrado');

        $input = new UpdateUserRequestDTO(1, 1, 'username', 'nome', 'email', 'phoneNumber', 1, 'dateOfBirth', 'cpfNumber', 'rgNumber', 'gender', false, false, false, null, true);
        $this->userRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn(null);

        $this->useCase->execute($input);
    }

    public function testErrorUpdatingUser()
    {
        $this->expectException(UserException::class);
        $this->expectExceptionMessage('Erro ao atualizar usuário');

        $input = new UpdateUserRequestDTO(1, 1, 'username', 'nome', 'email', 'phoneNumber', 1, 'dateOfBirth', 'cpfNumber', 'rgNumber', 'gender', false, false, false, null, true);

        $user = new User();
        $company = new Company();
        $company->id = 1;
        $company->name = 'company';

        $this->userRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn($user);
        $this->companyRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn($company);
        $this->processImageMock->expects($this->once())->method('execute')->willReturn('pathImage');
        $this->userRepositoryInterfaceMock->expects($this->once())->method('update')->willReturn(false);

        $this->useCase->execute($input);
    }

    public function testSuccess()
    {
        $user = new User();
        $company = new Company();
        $company->id = 1;
        $company->name = 'company';

        $input = new UpdateUserRequestDTO(1, 1, 'username', 'nome', 'email', 'phoneNumber', 1, 'dateOfBirth', 'cpfNumber', 'rgNumber', 'gender', false, false, false, null, true);
        $this->userRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn($user);
        $this->companyRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn($company);
        $this->processImageMock->expects($this->once())->method('execute')->willReturn('pathImage');
        $this->userRepositoryInterfaceMock->expects($this->once())->method('update')->willReturn(true);

        $this->useCase->execute($input);

        $this->assertTrue(true);
    }
}
