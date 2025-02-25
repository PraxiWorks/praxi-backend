<?php

namespace Tests\Application\Register\Client;

use App\Application\Register\Client\CreateClient;
use App\Application\Register\Client\DTO\CreateClientRequestDTO;
use App\Domain\Exceptions\Core\Company\CompanyException;
use App\Domain\Exceptions\Register\Client\ClientException;
use App\Domain\Exceptions\Settings\SettingsException;
use App\Domain\Interfaces\Core\Company\CompanyRepositoryInterface;
use App\Domain\Interfaces\Core\Permission\PermissionRepositoryInterface;
use App\Domain\Interfaces\Register\Client\ClientRepositoryInterface;
use App\Domain\Interfaces\Settings\Group\GroupRepositoryInterface;
use App\Domain\Interfaces\Settings\GroupPermission\GroupPermissionRepositoryInterface;
use App\Models\Core\Company\Company;
use App\Models\Register\Client\Client;
use App\Models\Settings\Group\Group;
use App\Services\Image\ProcessImage;
use Illuminate\Database\Eloquent\Collection;
use stdClass;
use Tests\TestCase;

class CreateClientTest extends TestCase
{

    private CompanyRepositoryInterface $companyRepositoryInterfaceMock;
    private ClientRepositoryInterface $clientRepositoryInterfaceMock;
    private GroupRepositoryInterface $groupRepositoryInterfaceMock;
    private PermissionRepositoryInterface $permissionRepositoryInterfaceMock;
    private GroupPermissionRepositoryInterface $groupPermissionRepositoryInterfaceMock;
    private ProcessImage $processImageMock;

    private CreateClient $useCase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->companyRepositoryInterfaceMock = $this->createMock(CompanyRepositoryInterface::class);
        $this->clientRepositoryInterfaceMock = $this->createMock(ClientRepositoryInterface::class);
        $this->groupRepositoryInterfaceMock = $this->createMock(GroupRepositoryInterface::class);
        $this->permissionRepositoryInterfaceMock = $this->createMock(PermissionRepositoryInterface::class);
        $this->groupPermissionRepositoryInterfaceMock = $this->createMock(GroupPermissionRepositoryInterface::class);
        $this->processImageMock = $this->createMock(ProcessImage::class);

        $this->useCase = new CreateClient(
            $this->companyRepositoryInterfaceMock,
            $this->clientRepositoryInterfaceMock,
            $this->groupRepositoryInterfaceMock,
            $this->permissionRepositoryInterfaceMock,
            $this->groupPermissionRepositoryInterfaceMock,
            $this->processImageMock
        );
    }

    public function testValidateInputThrowsExceptionForEmptyName()
    {
        $this->expectException(ClientException::class);
        $this->expectExceptionMessage('Nome é obrigatório');

        $input = new CreateClientRequestDTO(1, '', 'email', 'phoneNumber', 'dateOfBirth', 'cpfNumber', 'gender', false, false, false, null, false, 'password', true);
        $this->useCase->execute($input);
    }

    public function testValidateInputThrowsExceptionForEmptyEmail()
    {
        $this->expectException(ClientException::class);
        $this->expectExceptionMessage('Email é obrigatório');

        $input = new CreateClientRequestDTO(1, 'nome', '', 'phoneNumber', 'dateOfBirth', 'cpfNumber', 'gender', false, false, false, null, false, 'password', true);
        $this->useCase->execute($input);
    }

    public function testValidateInputThrowsExceptionForEmptyPassword()
    {
        $this->expectException(ClientException::class);
        $this->expectExceptionMessage('Senha é obrigatória');

        $input = new CreateClientRequestDTO(1, 'nome', 'email', 'phoneNumber', 'dateOfBirth', 'cpfNumber', 'gender', false, false, false, null, true, '', true);
        $this->useCase->execute($input);
    }

    public function testCompanyNotFound()
    {
        $this->expectException(CompanyException::class);
        $this->expectExceptionMessage('Empresa não encontrada');

        $input = new CreateClientRequestDTO(1, 'nome', 'email', 'phoneNumber', 'dateOfBirth', 'cpfNumber', 'gender', false, false, false, null, false, 'password', true);

        $this->companyRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn(null);

        $this->useCase->execute($input);
    }

    public function testErrorSavingGroup()
    {
        $this->expectException(SettingsException::class);
        $this->expectExceptionMessage('Erro ao criar o grupo');

        $input = new CreateClientRequestDTO(1, 'nome', 'email', 'phoneNumber', 'dateOfBirth', 'cpfNumber', 'gender', false, false, false, null, true, 'password', true);

        $companyMock = new Company();
        $companyMock->id = 1;
        $this->companyRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn($companyMock);

        $this->groupRepositoryInterfaceMock->expects($this->once())->method('findByNameAndCompanyId')->willReturn(null);
        $this->groupRepositoryInterfaceMock->expects($this->once())->method('save')->willReturn(false);

        $this->useCase->execute($input);
    }

    public function testErrorAssigningPermissionsToGroup()
    {
        $this->expectException(SettingsException::class);
        $this->expectExceptionMessage('Erro ao atribuir permissões ao grupo');

        $input = new CreateClientRequestDTO(1, 'nome', 'email', 'phoneNumber', 'dateOfBirth', 'cpfNumber', 'gender', false, false, false, null, true, 'password', true);

        $companyMock = new Company();
        $companyMock->id = 1;
        $this->companyRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn($companyMock);

        $this->groupRepositoryInterfaceMock->expects($this->once())->method('findByNameAndCompanyId')->willReturn(null);
        $groupMock = new Group();
        $this->groupRepositoryInterfaceMock->expects($this->once())->method('save')
            ->with($this->callback(function ($arg) use ($groupMock) {
                $arg->id = 1;
                return true;
            }))
            ->willReturn(true);

        $permission = new stdClass();
        $permission->id = 1;
        $collection = new Collection([
            $permission
        ]);
        $this->permissionRepositoryInterfaceMock->expects($this->once())->method('getPermissionByAction')->willReturn($collection);
        $this->groupPermissionRepositoryInterfaceMock->expects($this->once())->method('save')->willReturn(false);

        $this->useCase->execute($input);
    }

    public function testEmailAlreadyExists()
    {
        $this->expectException(ClientException::class);
        $this->expectExceptionMessage('Email já cadastrado');

        $input = new CreateClientRequestDTO(1, 'nome', 'email', 'phoneNumber', 'dateOfBirth', 'cpfNumber', 'gender', false, false, false, null, true, 'password', true);

        $companyMock = new Company();
        $companyMock->id = 1;
        $companyMock->name = 'companyName';
        $this->companyRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn($companyMock);

        $this->groupRepositoryInterfaceMock->expects($this->once())->method('findByNameAndCompanyId')->willReturn(null);
        $groupMock = new Group();
        $this->groupRepositoryInterfaceMock->expects($this->once())->method('save')
            ->with($this->callback(function ($arg) use ($groupMock) {
                $arg->id = 1;
                return true;
            }))
            ->willReturn(true);

        $permission = new stdClass();
        $permission->id = 1;
        $collection = new Collection([
            $permission
        ]);
        $this->permissionRepositoryInterfaceMock->expects($this->once())->method('getPermissionByAction')->willReturn($collection);
        $this->groupPermissionRepositoryInterfaceMock->expects($this->once())->method('save')->willReturn(true);

        $this->processImageMock->expects($this->once())->method('execute')->willReturn('pathImage');

        $clientMock = new Client();
        $this->clientRepositoryInterfaceMock->expects($this->once())->method('getByEmailAndCompanyId')->willReturn($clientMock);

        $this->useCase->execute($input);
    }

    public function testCpfAlreadyExists()
    {
        $this->expectException(ClientException::class);
        $this->expectExceptionMessage('CPF já cadastrado');

        $input = new CreateClientRequestDTO(1, 'nome', 'email', 'phoneNumber', 'dateOfBirth', 'cpfNumber', 'gender', false, false, false, null, true, 'password', true);

        $companyMock = new Company();
        $companyMock->id = 1;
        $companyMock->name = 'companyName';
        $this->companyRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn($companyMock);

        $this->groupRepositoryInterfaceMock->expects($this->once())->method('findByNameAndCompanyId')->willReturn(null);
        $groupMock = new Group();
        $this->groupRepositoryInterfaceMock->expects($this->once())->method('save')
            ->with($this->callback(function ($arg) use ($groupMock) {
                $arg->id = 1;
                return true;
            }))
            ->willReturn(true);

        $permission = new stdClass();
        $permission->id = 1;
        $collection = new Collection([
            $permission
        ]);
        $this->permissionRepositoryInterfaceMock->expects($this->once())->method('getPermissionByAction')->willReturn($collection);
        $this->groupPermissionRepositoryInterfaceMock->expects($this->once())->method('save')->willReturn(true);

        $this->processImageMock->expects($this->once())->method('execute')->willReturn('pathImage');

        $clientMock = new Client();
        $this->clientRepositoryInterfaceMock->expects($this->once())->method('getByEmailAndCompanyId')->willReturn(null);
        $this->clientRepositoryInterfaceMock->expects($this->once())->method('getByCpfAndCompanyId')->willReturn($clientMock);

        $this->useCase->execute($input);
    }

    public function testErrorSavingClient()
    {
        $this->expectException(ClientException::class);
        $this->expectExceptionMessage('Erro ao salvar cliente');

        $input = new CreateClientRequestDTO(1, 'nome', 'email', 'phoneNumber', 'dateOfBirth', 'cpfNumber', 'gender', false, false, false, null, true, 'password', true);

        $companyMock = new Company();
        $companyMock->id = 1;
        $companyMock->name = 'companyName';
        $this->companyRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn($companyMock);

        $this->groupRepositoryInterfaceMock->expects($this->once())->method('findByNameAndCompanyId')->willReturn(null);
        $groupMock = new Group();
        $this->groupRepositoryInterfaceMock->expects($this->once())->method('save')
            ->with($this->callback(function ($arg) use ($groupMock) {
                $arg->id = 1;
                return true;
            }))
            ->willReturn(true);

        $permission = new stdClass();
        $permission->id = 1;
        $collection = new Collection([
            $permission
        ]);
        $this->permissionRepositoryInterfaceMock->expects($this->once())->method('getPermissionByAction')->willReturn($collection);
        $this->groupPermissionRepositoryInterfaceMock->expects($this->once())->method('save')->willReturn(true);

        $this->processImageMock->expects($this->once())->method('execute')->willReturn('pathImage');

        $this->clientRepositoryInterfaceMock->expects($this->once())->method('getByEmailAndCompanyId')->willReturn(null);
        $this->clientRepositoryInterfaceMock->expects($this->once())->method('getByCpfAndCompanyId')->willReturn(null);
        $this->clientRepositoryInterfaceMock->expects($this->once())->method('save')->willReturn(false);

        $this->useCase->execute($input);
    }

    public function testSuccess()
    {
        $input = new CreateClientRequestDTO(1, 'nome', 'email', 'phoneNumber', 'dateOfBirth', 'cpfNumber', 'gender', false, false, false, null, true, 'password', true);

        $companyMock = new Company();
        $companyMock->id = 1;
        $companyMock->name = 'companyName';
        $this->companyRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn($companyMock);

        $groupMock = new Group();
        $groupMock->id = 1;
        $this->groupRepositoryInterfaceMock->expects($this->once())->method('findByNameAndCompanyId')->willReturn($groupMock);

        $this->processImageMock->expects($this->once())->method('execute')->willReturn('pathImage');

        $this->clientRepositoryInterfaceMock->expects($this->once())->method('getByEmailAndCompanyId')->willReturn(null);
        $this->clientRepositoryInterfaceMock->expects($this->once())->method('getByCpfAndCompanyId')->willReturn(null);
        $this->clientRepositoryInterfaceMock->expects($this->once())->method('save')->willReturn(true);

        $this->useCase->execute($input);

        $this->assertTrue(true);
    }
}
