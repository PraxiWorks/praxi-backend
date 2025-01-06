<?php

namespace Tests\Application\Register\Client;

use App\Application\Register\Client\DTO\UpdateClientRequestDTO;
use App\Application\Register\Client\UpdateClient;
use App\Domain\Exceptions\Register\Client\ClientException;
use App\Domain\Exceptions\Register\Client\ClientNotFoundException;
use App\Domain\Interfaces\Core\Company\CompanyRepositoryInterface;
use App\Domain\Interfaces\Register\Client\ClientRepositoryInterface;
use App\Domain\Interfaces\Register\Group\GroupRepositoryInterface;
use App\Models\Core\Company\Company;
use App\Models\Register\Client\Client;
use App\Services\Image\ProcessImage;
use Tests\TestCase;

class UpdateClientTest extends TestCase
{

    private ClientRepositoryInterface $clientRepositoryInterfaceMock;
    private GroupRepositoryInterface $groupRepositoryInterfaceMock;
    private CompanyRepositoryInterface $companyRepositoryInterfaceMock;
    private ProcessImage $processImageMock;

    private UpdateClient $useCase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->companyRepositoryInterfaceMock = $this->createMock(CompanyRepositoryInterface::class);
        $this->clientRepositoryInterfaceMock = $this->createMock(ClientRepositoryInterface::class);
        $this->groupRepositoryInterfaceMock = $this->createMock(GroupRepositoryInterface::class);
        $this->processImageMock = $this->createMock(ProcessImage::class);

        $this->useCase = new UpdateClient(
            $this->clientRepositoryInterfaceMock,
            $this->groupRepositoryInterfaceMock,
            $this->companyRepositoryInterfaceMock,
            $this->processImageMock
        );
    }

    public function testValidateInputThrowsExceptionForEmptyName()
    {
        $this->expectException(ClientException::class);
        $this->expectExceptionMessage('Nome é obrigatório');

        $input = new UpdateClientRequestDTO(1, 1, '', 'email', 'phoneNumber', 'dateOfBirth', 'cpfNumber', 'rgNumber', 'gender', false, false, false, null, false, true);
        $this->useCase->execute($input);
    }

    public function testValidateInputThrowsExceptionForEmptyEmail()
    {
        $this->expectException(ClientException::class);
        $this->expectExceptionMessage('Email é obrigatório');

        $input = new UpdateClientRequestDTO(1, 1, 'name', '', 'phoneNumber', 'dateOfBirth', 'cpfNumber', 'rgNumber', 'gender', false, false, false, null, false, true);
        $this->useCase->execute($input);
    }

    public function testClientNotFound()
    {
        $this->expectException(ClientNotFoundException::class);
        $this->expectExceptionMessage('Cliente não encontrado');

        $input = new UpdateClientRequestDTO(1, 1, 'nome', 'email', 'phoneNumber', 'dateOfBirth', 'cpfNumber', 'rgNumber', 'gender', false, false, false, null, false, true);
        $this->clientRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn(null);

        $this->useCase->execute($input);
    }

    public function testErrorSavingClient()
    {
        $this->expectException(ClientException::class);
        $this->expectExceptionMessage('Erro ao atualizar cliente');

        $input = new UpdateClientRequestDTO(1, 1, 'nome', 'email', 'phoneNumber', 'dateOfBirth', 'cpfNumber', 'rgNumber', 'gender', false, false, false, null, false, true);

        $clientMock = new Client();
        $this->clientRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn($clientMock);

        $companyMock = new Company();
        $companyMock->id = 1;
        $companyMock->name = 'companyName';
        $this->companyRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn($companyMock);

        $this->processImageMock->expects($this->once())->method('execute')->willReturn('pathImage');

        $this->clientRepositoryInterfaceMock->expects($this->once())->method('update')->willReturn(false);

        $this->useCase->execute($input);
    }

    public function testSuccess()
    {
        $input = new UpdateClientRequestDTO(1, 1, 'nome', 'email', 'phoneNumber', 'dateOfBirth', 'cpfNumber', 'rgNumber', 'gender', false, false, false, null, false, true);

        $clientMock = new Client();
        $this->clientRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn($clientMock);

        $companyMock = new Company();
        $companyMock->id = 1;
        $companyMock->name = 'companyName';
        $this->companyRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn($companyMock);

        $this->processImageMock->expects($this->once())->method('execute')->willReturn('pathImage');

        $this->clientRepositoryInterfaceMock->expects($this->once())->method('update')->willReturn(true);

        $this->useCase->execute($input);

        $this->assertTrue(true);
    }
}
