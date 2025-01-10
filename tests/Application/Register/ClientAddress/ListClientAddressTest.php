<?php

namespace Tests\Application\Register\ClientAddress;

use App\Application\DTO\IdRequestDTO;
use App\Application\Register\ClientAddress\ListClientAddress;
use App\Domain\Interfaces\Register\ClientAddress\ClientAddressRepositoryInterface;
use Tests\TestCase;

class ListClientAddressTest extends TestCase
{
    private ClientAddressRepositoryInterface $clientAddressRepositoryInterfaceMock;

    private ListClientAddress $useCase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->clientAddressRepositoryInterfaceMock = $this->createMock(ClientAddressRepositoryInterface::class);

        $this->useCase = new ListClientAddress(
            $this->clientAddressRepositoryInterfaceMock
        );
    }

    public function testExecuteReturnsExpectedClientAddressesList()
    {
        // Define o valor de retorno esperado do método list
        $clientAddresses = $this->clientAddressesMock();

        $input = new IdRequestDTO(1);
        $this->clientAddressRepositoryInterfaceMock->expects($this->once())->method('list')->willReturn($clientAddresses);

        $result = $this->useCase->execute($input);

        // Verifica se o resultado é o esperado
        $this->assertEquals($clientAddresses, $result);
    }

    public function clientAddressesMock()
    {
        return [
            [
                'id' => 1,
                'client_id' => 1,
                'country' => 'Brasil',
                'zip_code' => '12345678',
                'state' => 'SP',
                'city' => 'São Paulo',
                'neighborhood' => 'Vila Mariana',
                'street' => 'Rua Domingos de Morais',
                'number' => 123,
                'complement' => 'Apto 123'
            ]
        ];
    }
}
