<?php

namespace Tests\Application\Register\ClientAddress;

use App\Application\Register\ClientAddress\DTO\UpdateClientAddressRequestDTO;
use App\Application\Register\ClientAddress\UpdateClientAddress;
use App\Domain\Exceptions\Register\ClientAddress\ClientAddressException;
use App\Domain\Exceptions\Register\ClientAddress\ClientAddressNotFoundException;
use App\Domain\Interfaces\Register\ClientAddress\ClientAddressRepositoryInterface;
use App\Models\Register\ClientAddress\ClientAddress;
use Tests\TestCase;

class UpdateClientAddressTest extends TestCase
{

    private ClientAddressRepositoryInterface $clientAddressRepositoryInterfaceMock;

    private UpdateClientAddress $useCase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->clientAddressRepositoryInterfaceMock = $this->createMock(ClientAddressRepositoryInterface::class);

        $this->useCase = new UpdateClientAddress(
            $this->clientAddressRepositoryInterfaceMock
        );
    }

    public function testValidateInputThrowsExceptionForEmptyContry()
    {
        $this->expectException(ClientAddressException::class);
        $this->expectExceptionMessage('Pais é obrigatório');

        $input = new UpdateClientAddressRequestDTO(1, 1, '', 'zipCode', 'state', 'city', 'neighborhood', 'street', 556, 'complement');
        $this->useCase->execute($input);
    }

    public function testValidateInputThrowsExceptionForEmptyState()
    {
        $this->expectException(ClientAddressException::class);
        $this->expectExceptionMessage('Estado é obrigatório');

        $input = new UpdateClientAddressRequestDTO(1, 1, 'country', 'zipCode', '', 'city', 'neighborhood', 'street', 556, 'complement');
        $this->useCase->execute($input);
    }

    public function testValidateInputThrowsExceptionForEmptyCity()
    {
        $this->expectException(ClientAddressException::class);
        $this->expectExceptionMessage('Cidade é obrigatório');

        $input = new UpdateClientAddressRequestDTO(1, 1, 'country', 'zipCode', 'state', '', 'neighborhood', 'street', 556, 'complement');
        $this->useCase->execute($input);
    }


    public function testClientAddressNotFound()
    {
        $this->expectException(ClientAddressNotFoundException::class);
        $this->expectExceptionMessage('Endereço do cliente não encontrado');

        $input = new UpdateClientAddressRequestDTO(1, 1, 'country', 'zipCode', 'state', 'city', 'neighborhood', 'street', 556, 'complement');

        $this->clientAddressRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn(null);

        $this->useCase->execute($input);
    }

    public function testErrorUpdatingClientAddress()
    {
        $this->expectException(ClientAddressException::class);
        $this->expectExceptionMessage('Erro ao atualizar endereço do cliente');

        $input = new UpdateClientAddressRequestDTO(1, 1, 'country', 'zipCode', 'state', 'city', 'neighborhood', 'street', 556, 'complement');

        $clientAddressMock = new ClientAddress();
        $this->clientAddressRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn($clientAddressMock);
        $this->clientAddressRepositoryInterfaceMock->expects($this->once())->method('update')->willReturn(false);

        $this->useCase->execute($input);
    }

    public function testSuccess()
    {

        $input = new UpdateClientAddressRequestDTO(1, 1, 'country', 'zipCode', 'state', 'city', 'neighborhood', 'street', 556, 'complement');

        $clientAddressMock = new ClientAddress();
        $this->clientAddressRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn($clientAddressMock);
        $this->clientAddressRepositoryInterfaceMock->expects($this->once())->method('update')->willReturn(true);

        $result = $this->useCase->execute($input);

        $this->assertTrue($result);
    }
}
