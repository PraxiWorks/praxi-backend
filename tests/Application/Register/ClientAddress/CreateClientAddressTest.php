<?php

namespace Tests\Application\Register\ClientAddress;

use App\Application\Register\ClientAddress\CreateClientAddress;
use App\Application\Register\ClientAddress\DTO\CreateClientAddressRequestDTO;
use App\Domain\Exceptions\Register\ClientAddress\ClientAddressException;
use App\Domain\Interfaces\Register\ClientAddress\ClientAddressRepositoryInterface;
use App\Models\Register\ClientAddress\ClientAddress;
use Tests\TestCase;

class CreateClientAddressTest extends TestCase
{

    private ClientAddressRepositoryInterface $clientAddressRepositoryInterfaceMock;

    private CreateClientAddress $useCase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->clientAddressRepositoryInterfaceMock = $this->createMock(ClientAddressRepositoryInterface::class);

        $this->useCase = new CreateClientAddress(
            $this->clientAddressRepositoryInterfaceMock
        );
    }

    public function testValidateInputThrowsExceptionForEmptyContry()
    {
        $this->expectException(ClientAddressException::class);
        $this->expectExceptionMessage('Pais é obrigatório');

        $input = new CreateClientAddressRequestDTO(1, '', 'zipCode', 'state', 'city', 'neighborhood', 'street', 556, 'complement');
        $this->useCase->execute($input);
    }

    public function testValidateInputThrowsExceptionForEmptyState()
    {
        $this->expectException(ClientAddressException::class);
        $this->expectExceptionMessage('Estado é obrigatório');

        $input = new CreateClientAddressRequestDTO(1, 'country', 'zipCode', '', 'city', 'neighborhood', 'street', 556, 'complement');
        $this->useCase->execute($input);
    }

    public function testValidateInputThrowsExceptionForEmptyCity()
    {
        $this->expectException(ClientAddressException::class);
        $this->expectExceptionMessage('Cidade é obrigatório');

        $input = new CreateClientAddressRequestDTO(1, 'country', 'zipCode', 'state', '', 'neighborhood', 'street', 556, 'complement');
        $this->useCase->execute($input);
    }


    public function testClientAddressAlreadyExists()
    {
        $this->expectException(ClientAddressException::class);
        $this->expectExceptionMessage('Endereço já cadastrado para este cliente');

        $input = new CreateClientAddressRequestDTO(1, 'country', 'zipCode', 'state', 'city', 'neighborhood', 'street', 556, 'complement');

        $clientAddressMock = new ClientAddress();
        $this->clientAddressRepositoryInterfaceMock->expects($this->once())->method('getByClientId')->willReturn($clientAddressMock);

        $this->useCase->execute($input);
    }

    public function testErrorSavingClientAddress()
    {
        $this->expectException(ClientAddressException::class);
        $this->expectExceptionMessage('Erro ao salvar endereço');

        $input = new CreateClientAddressRequestDTO(1, 'country', 'zipCode', 'state', 'city', 'neighborhood', 'street', 556, 'complement');

        $this->clientAddressRepositoryInterfaceMock->expects($this->once())->method('getByClientId')->willReturn(null);
        $this->clientAddressRepositoryInterfaceMock->expects($this->once())->method('save')->willReturn(false);

        $this->useCase->execute($input);
    }

    public function testSuccess()
    {

        $input = new CreateClientAddressRequestDTO(1, 'country', 'zipCode', 'state', 'city', 'neighborhood', 'street', 556, 'complement');

        $this->clientAddressRepositoryInterfaceMock->expects($this->once())->method('getByClientId')->willReturn(null);
        $this->clientAddressRepositoryInterfaceMock->expects($this->once())->method('save')->willReturn(true);

        $result = $this->useCase->execute($input);

        $this->assertTrue($result);
    }
}
