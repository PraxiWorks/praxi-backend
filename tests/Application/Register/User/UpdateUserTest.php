<?php

namespace Tests\Application\User;

use App\Application\Register\User\DTO\UpdateUserRequestDTO;
use App\Application\Register\User\UpdateUser;
use App\Domain\Exceptions\Register\User\UserException;
use App\Domain\Exceptions\Register\User\UserNotFoundException;
use App\Domain\Exceptions\Settings\SettingsNotFoundException;
use App\Domain\Interfaces\Core\Company\CompanyRepositoryInterface;
use App\Domain\Interfaces\Register\Group\GroupRepositoryInterface;
use App\Domain\Interfaces\Register\User\UserRepositoryInterface;
use App\Models\Core\Company\Company;
use App\Models\Register\Group\Group;
use App\Models\Register\User\User;
use App\Services\Image\ProcessImage;
use Tests\TestCase;

class UpdateUserTest extends TestCase
{
    private UserRepositoryInterface $userRepositoryInterfaceMock;
    private GroupRepositoryInterface $groupRepositoryInterfaceMock;
    private CompanyRepositoryInterface $companyRepositoryInterfaceMock;
    private ProcessImage $processImageMock;

    private UpdateUser $useCase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->userRepositoryInterfaceMock = $this->createMock(UserRepositoryInterface::class);
        $this->groupRepositoryInterfaceMock = $this->createMock(GroupRepositoryInterface::class);
        $this->companyRepositoryInterfaceMock = $this->createMock(CompanyRepositoryInterface::class);
        $this->processImageMock = $this->createMock(ProcessImage::class);

        $this->useCase = new UpdateUser(
            $this->userRepositoryInterfaceMock,
            $this->groupRepositoryInterfaceMock,
            $this->companyRepositoryInterfaceMock,
            $this->processImageMock
        );
    }

    public function testValidateInputThrowsExceptionForEmptyUsername()
    {
        $this->expectException(UserException::class);
        $this->expectExceptionMessage('Nome de usuário não informado');

        $input = new UpdateUserRequestDTO(1, 1, '', 'name', 'email', 'phoneNumber', 'dateOfBirth', 'cpfNumber', 'rgNumber', 'gender', false, false, false, null, false, 1, true);
        $this->useCase->execute($input);
    }

    public function testValidateInputThrowsExceptionForEmptyName()
    {
        $this->expectException(UserException::class);
        $this->expectExceptionMessage('Nome não informado');

        $input = new UpdateUserRequestDTO(1, 1, 'username', '', 'email', 'phoneNumber', 'dateOfBirth', 'cpfNumber', 'rgNumber', 'gender', false, false, false, null, false, 1, true);
        $this->useCase->execute($input);
    }

    public function testValidateInputThrowsExceptionForEmptyEmail()
    {
        $this->expectException(UserException::class);
        $this->expectExceptionMessage('Email não informado');

        $input = new UpdateUserRequestDTO(1, 1, 'username', 'nome', '', 'phoneNumber', 'dateOfBirth', 'cpfNumber', 'rgNumber', 'gender', false, false, false, null, false, 1, true);
        $this->useCase->execute($input);
    }

    public function testUserNotFound()
    {
        $this->expectException(UserNotFoundException::class);
        $this->expectExceptionMessage('Usuário não encontrado');

        $input = new UpdateUserRequestDTO(1, 1, 'username', 'nome', 'email', 'phoneNumber', 'dateOfBirth', 'cpfNumber', 'rgNumber', 'gender', false, false, false, null, false, 1, true);
        $this->userRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn(null);

        $this->useCase->execute($input);
    }

    public function testGroupNotFound()
    {
        $this->expectException(SettingsNotFoundException::class);
        $this->expectExceptionMessage('Grupo não encontrado');

        $user = new User();

        $input = new UpdateUserRequestDTO(1, 1, 'username', 'nome', 'email', 'phoneNumber', 'dateOfBirth', 'cpfNumber', 'rgNumber', 'gender', false, false, false, null, false, 1, true);
        $this->userRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn($user);
        $this->groupRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn(null);

        $this->useCase->execute($input);
    }

    public function testErrorUpdatingUser()
    {
        $this->expectException(UserException::class);
        $this->expectExceptionMessage('Erro ao atualizar usuário');

        $input = new UpdateUserRequestDTO(1, 1, 'username', 'nome', 'email', 'phoneNumber', 'dateOfBirth', 'cpfNumber', 'rgNumber', 'gender', false, false, false, null, false, 1, true);

        $user = new User();

        $group = new Group();

        $company = new Company();
        $company->id = 1;
        $company->name = 'company';

        $this->userRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn($user);
        $this->groupRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn($group);
        $this->companyRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn($company);
        $this->processImageMock->expects($this->once())->method('execute')->willReturn('pathImage');
        $this->userRepositoryInterfaceMock->expects($this->once())->method('update')->willReturn(false);

        $this->useCase->execute($input);
    }

    public function testSuccess()
    {
        $user = new User();
        $group = new Group();
        $company = new Company();
        $company->id = 1;
        $company->name = 'company';

        $input = new UpdateUserRequestDTO(1, 1, 'username', 'nome', 'email', 'phoneNumber', 'dateOfBirth', 'cpfNumber', 'rgNumber', 'gender', false, false, false, null, false, 1, true);
        $this->userRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn($user);
        $this->groupRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn($group);
        $this->companyRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn($company);
        $this->processImageMock->expects($this->once())->method('execute')->willReturn('pathImage');
        $this->userRepositoryInterfaceMock->expects($this->once())->method('update')->willReturn(true);

        $this->useCase->execute($input);

        $this->assertTrue(true);
    }
}
