<?php

namespace Tests\Application\User;

use App\Application\User\CreateUser;
use App\Application\User\DTO\CreateUserRequestDTO;
use App\Domain\Exceptions\Company\CompanyException;
use App\Domain\Exceptions\User\UserException;
use App\Domain\Exceptions\User\UserTypeNotFoundException;
use App\Domain\Interfaces\Company\CompanyRepositoryInterface;
use App\Domain\Interfaces\Storage\LocalStorageRepositoryInterface;
use App\Domain\Interfaces\User\UserRepositoryInterface;
use App\Domain\Interfaces\User\UserTypeRepositoryInterface;
use App\Models\Company\Company;
use App\Models\User\User;
use App\Models\User\UserType;
use Tests\TestCase;

class CreateUserTest extends TestCase
{
    private CompanyRepositoryInterface $companyRepositoryInterfaceMock;
    private UserRepositoryInterface $userRepositoryInterfaceMock;
    private UserTypeRepositoryInterface $userTypeRepositoryInterfaceMock;
    private LocalStorageRepositoryInterface $localStorageRepositoryMock;

    private CreateUser $useCase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->companyRepositoryInterfaceMock = $this->createMock(CompanyRepositoryInterface::class);
        $this->userRepositoryInterfaceMock = $this->createMock(UserRepositoryInterface::class);
        $this->userTypeRepositoryInterfaceMock = $this->createMock(UserTypeRepositoryInterface::class);
        $this->localStorageRepositoryMock = $this->createMock(LocalStorageRepositoryInterface::class);

        $this->useCase = new CreateUser(
            $this->companyRepositoryInterfaceMock,
            $this->userRepositoryInterfaceMock,
            $this->userTypeRepositoryInterfaceMock,
            $this->localStorageRepositoryMock
        );
    }

    public function testValidateInputThrowsExceptionForEmptyName()
    {
        $this->expectException(UserException::class);
        $this->expectExceptionMessage('Nome não informado');

        $input = new CreateUserRequestDTO(1, '', 'email', 'phoneNumber', 1, 'dateOfBirth', 'cpfNumber', 'rgNumber', 'gender', false, false, false, null, 'password', true);
        $this->useCase->execute($input);
    }

    public function testValidateInputThrowsExceptionForEmptyEmail()
    {
        $this->expectException(UserException::class);
        $this->expectExceptionMessage('Email não informado');

        $input = new CreateUserRequestDTO(1, 'nome', '', 'phoneNumber', 1, 'dateOfBirth', 'cpfNumber', 'rgNumber', 'gender', false, false, false, null, 'password', true);
        $this->useCase->execute($input);
    }

    public function testValidateInputThrowsExceptionForEmptyTypeId()
    {
        $this->expectException(UserException::class);
        $this->expectExceptionMessage('Tipo de usuário não informado');

        $input = new CreateUserRequestDTO(1, 'nome', 'email', 'phoneNumber', 0, 'dateOfBirth', 'cpfNumber', 'rgNumber', 'gender', false, false, false, null, 'password', true);
        $this->useCase->execute($input);
    }

    public function testCompanyNotFound()
    {
        $this->expectException(CompanyException::class);
        $this->expectExceptionMessage('Empresa não encontrada');

        $input = new CreateUserRequestDTO(1, 'nome', 'email', 'phoneNumber', 1, 'dateOfBirth', 'cpfNumber', 'rgNumber', 'gender', false, false, false, null, 'password', true);
        $this->companyRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn(null);

        $this->useCase->execute($input);
    }

    public function testEmailAlreadyExists()
    {
        $this->expectException(UserException::class);
        $this->expectExceptionMessage('Email já cadastrado');

        $company = new Company();
        $user = new User();

        $input = new CreateUserRequestDTO(1, 'nome', 'email', 'phoneNumber', 1, 'dateOfBirth', 'cpfNumber', 'rgNumber', 'gender', false, false, false, null, 'password', true);
        $this->companyRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn($company);
        $this->userRepositoryInterfaceMock->expects($this->once())->method('getByEmail')->willReturn($user);

        $this->useCase->execute($input);
    }

    public function testUserTypeNotFound()
    {
        $this->expectException(UserTypeNotFoundException::class);
        $this->expectExceptionMessage('Tipo de usuário não encontrado');

        $company = new Company();

        $input = new CreateUserRequestDTO(1, 'nome', 'email', 'phoneNumber', 1, 'dateOfBirth', 'cpfNumber', 'rgNumber', 'gender', false, false, false, null, 'password', true);
        $this->companyRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn($company);
        $this->userRepositoryInterfaceMock->expects($this->once())->method('getByEmail')->willReturn(null);
        $this->userTypeRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn(null);

        $this->useCase->execute($input);
    }

    public function testErrorSavingUser()
    {
        $this->expectException(UserException::class);
        $this->expectExceptionMessage('Erro ao salvar usuário');

        $company = new Company();
        $company->name = 'companyName';
        $userType = new UserType();

        $input = new CreateUserRequestDTO(1, 'nome', 'email', 'phoneNumber', 1, 'dateOfBirth', 'cpfNumber', 'rgNumber', 'gender', false, false, false, null, 'password', true);
        $this->companyRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn($company);
        $this->userRepositoryInterfaceMock->expects($this->once())->method('getByEmail')->willReturn(null);
        $this->userTypeRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn($userType);
        $this->userRepositoryInterfaceMock->expects($this->once())->method('save')->willReturn(false);

        $this->useCase->execute($input);
    }

    public function testSuccess()
    {
        $company = new Company();
        $company->name = 'companyName';
        $userType = new UserType();

        $input = new CreateUserRequestDTO(1, 'nome', 'email', 'phoneNumber', 1, 'dateOfBirth', 'cpfNumber', 'rgNumber', 'gender', false, false, false, null, 'password', true);
        $this->companyRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn($company);
        $this->userRepositoryInterfaceMock->expects($this->once())->method('getByEmail')->willReturn(null);
        $this->userTypeRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn($userType);
        $this->userRepositoryInterfaceMock->expects($this->once())->method('save')->willReturn(true);

        $this->useCase->execute($input);

        $this->assertTrue(true);
    }
}
