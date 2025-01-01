<?php

namespace Tests\Application\Register\User;

use App\Application\Register\User\CreateUser;
use App\Application\Register\User\DTO\CreateUserRequestDTO;
use App\Domain\Exceptions\Company\CompanyException;
use App\Domain\Exceptions\Register\User\UserException;
use App\Domain\Exceptions\Settings\SettingsNotFoundException;
use App\Domain\Interfaces\Core\Company\CompanyRepositoryInterface;
use App\Domain\Interfaces\Register\Group\GroupRepositoryInterface;
use App\Domain\Interfaces\Register\User\UserRepositoryInterface;
use App\Models\Core\Company\Company;
use App\Models\Register\Group\Group;
use App\Models\Register\User\User;
use App\Services\Image\ProcessImage;
use Tests\TestCase;

class CreateUserTest extends TestCase
{
    private CompanyRepositoryInterface $companyRepositoryInterfaceMock;
    private UserRepositoryInterface $userRepositoryInterfaceMock;
    private GroupRepositoryInterface $groupRepositoryInterfaceMock;
    private ProcessImage $processImageMock;

    private CreateUser $useCase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->companyRepositoryInterfaceMock = $this->createMock(CompanyRepositoryInterface::class);
        $this->userRepositoryInterfaceMock = $this->createMock(UserRepositoryInterface::class);
        $this->groupRepositoryInterfaceMock = $this->createMock(GroupRepositoryInterface::class);
        $this->processImageMock = $this->createMock(ProcessImage::class);

        $this->useCase = new CreateUser(
            $this->companyRepositoryInterfaceMock,
            $this->userRepositoryInterfaceMock,
            $this->groupRepositoryInterfaceMock,
            $this->processImageMock
        );
    }

    public function testValidateInputThrowsExceptionForEmptyUsername()
    {
        $this->expectException(UserException::class);
        $this->expectExceptionMessage('Nome de usuário não informado');

        $input = new CreateUserRequestDTO(1, '', 'name', 'email', 'phoneNumber', 'dateOfBirth', 'cpfNumber', 'rgNumber', 'gender', false, false, false, null, 'password', false, 1, true);
        $this->useCase->execute($input);
    }

    public function testValidateInputThrowsExceptionForEmptyName()
    {
        $this->expectException(UserException::class);
        $this->expectExceptionMessage('Nome não informado');

        $input = new CreateUserRequestDTO(1, 'username', '', 'email', 'phoneNumber', 'dateOfBirth', 'cpfNumber', 'rgNumber', 'gender', false, false, false, null, 'password', false, 1, true);
        $this->useCase->execute($input);
    }

    public function testValidateInputThrowsExceptionForEmptyEmail()
    {
        $this->expectException(UserException::class);
        $this->expectExceptionMessage('Email não informado');

        $input = new CreateUserRequestDTO(1, 'username', 'nome', '', 'phoneNumber', 'dateOfBirth', 'cpfNumber', 'rgNumber', 'gender', false, false, false, null, 'password', false, 1, true);
        $this->useCase->execute($input);
    }

    public function testCompanyNotFound()
    {
        $this->expectException(CompanyException::class);
        $this->expectExceptionMessage('Empresa não encontrada');

        $input = new CreateUserRequestDTO(1, 'username', 'nome', 'email', 'phoneNumber', 'dateOfBirth', 'cpfNumber', 'rgNumber', 'gender', false, false, false, null, 'password', false, 1, true);
        $this->companyRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn(null);

        $this->useCase->execute($input);
    }

    public function testEmailAlreadyExists()
    {
        $this->expectException(UserException::class);
        $this->expectExceptionMessage('Email já cadastrado');

        $company = new Company();
        $company->id = 1;
        $user = new User();

        $input = new CreateUserRequestDTO(1, 'username', 'nome', 'email', 'phoneNumber', 'dateOfBirth', 'cpfNumber', 'rgNumber', 'gender', false, false, false, null, 'password', false, 1, true);
        $this->companyRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn($company);
        $this->userRepositoryInterfaceMock->expects($this->once())->method('getByEmailAndCompanyId')->willReturn($user);

        $this->useCase->execute($input);
    }

    public function testGroupNotFound()
    {
        $this->expectException(SettingsNotFoundException::class);
        $this->expectExceptionMessage('Grupo não encontrado');

        $company = new Company();
        $company->id = 1;

        $input = new CreateUserRequestDTO(1, 'username', 'nome', 'email', 'phoneNumber', 'dateOfBirth', 'cpfNumber', 'rgNumber', 'gender', false, false, false, null, 'password', false, 1, true);
        $this->companyRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn($company);
        $this->userRepositoryInterfaceMock->expects($this->once())->method('getByEmailAndCompanyId')->willReturn(null);
        $this->groupRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn(null);

        $this->useCase->execute($input);
    }

    public function testErrorSavingUser()
    {
        $this->expectException(UserException::class);
        $this->expectExceptionMessage('Erro ao salvar usuário');

        $company = new Company();
        $company->id = 1;
        $company->name = 'companyName';

        $group = new Group();

        $input = new CreateUserRequestDTO(1, 'username', 'nome', 'email', 'phoneNumber', 'dateOfBirth', 'cpfNumber', 'rgNumber', 'gender', false, false, false, null, 'password', false, 1, true);
        $this->companyRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn($company);
        $this->userRepositoryInterfaceMock->expects($this->once())->method('getByEmailAndCompanyId')->willReturn(null);
        $this->groupRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn($group);
        $this->processImageMock->expects($this->once())->method('execute')->willReturn('pathImage');
        $this->userRepositoryInterfaceMock->expects($this->once())->method('save')->willReturn(false);

        $this->useCase->execute($input);
    }

    public function testSuccess()
    {
        $company = new Company();
        $company->id = 1;
        $company->name = 'companyName';

        $group = new Group();

        $input = new CreateUserRequestDTO(1, 'username', 'nome', 'email', 'phoneNumber', 'dateOfBirth', 'cpfNumber', 'rgNumber', 'gender', false, false, false, null, 'password', false, 1, true);
        $this->companyRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn($company);
        $this->userRepositoryInterfaceMock->expects($this->once())->method('getByEmailAndCompanyId')->willReturn(null);
        $this->groupRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn($group);
        $this->processImageMock->expects($this->once())->method('execute')->willReturn('pathImage');
        $this->userRepositoryInterfaceMock->expects($this->once())->method('save')->willReturn(true);

        $this->useCase->execute($input);

        $this->assertTrue(true);
    }
}
