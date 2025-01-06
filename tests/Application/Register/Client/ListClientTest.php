<?php

namespace Tests\Application\Register\Client;

use App\Application\DTO\IdRequestDTO;
use App\Application\Register\Client\ListClients;
use App\Domain\Interfaces\Register\Client\ClientRepositoryInterface;
use Tests\TestCase;

class ListClientTest extends TestCase
{
    private ClientRepositoryInterface $clientRepositoryInterfaceMock;

    private ListClients $useCase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->clientRepositoryInterfaceMock = $this->createMock(ClientRepositoryInterface::class);

        $this->useCase = new ListClients(
            $this->clientRepositoryInterfaceMock
        );
    }

    public function testExecuteReturnsExpectedClientsList()
    {
        // Define o valor de retorno esperado do método list
        $clients = $this->clientsMock();

        $input = new IdRequestDTO(1);
        $this->clientRepositoryInterfaceMock->expects($this->once())->method('list')->willReturn($clients);

        $result = $this->useCase->execute($input);

        // Verifica se o resultado é o esperado
        $this->assertEquals($clients, $result);
    }

    public function clientsMock()
    {
        return [
            [
                'id' => 1,
                'company_id' => 1,
                'name' => 'User 1',
                'email' => 'email@gmail.com',
                'phone_number' => '123456789',
                'company_id' => 1,
                'date_of_birth' => '2021-01-01',
                'cpf_number' => '123456789',
                'rg_number' => '123456789',
                'gender' => 'Male',
                'send_notification_email' => true,
                'send_notification_sms' => true,
                'send_notification_whatsapp' => true,
                'path_image' => 'path/image',
                'password' => 'password',
                'has_access_to_the_system' => true,
                'group_id' => 1,
                'status' => true
            ],
            [
                'id' => 1,
                'company_id' => 1,
                'name' => 'User 1',
                'email' => 'email@gmail.com',
                'phone_number' => '123456789',
                'company_id' => 1,
                'date_of_birth' => '2021-01-01',
                'cpf_number' => '123456789',
                'rg_number' => '123456789',
                'gender' => 'Male',
                'send_notification_email' => true,
                'send_notification_sms' => true,
                'send_notification_whatsapp' => true,
                'path_image' => 'path/image',
                'password' => 'password',
                'has_access_to_the_system' => true,
                'group_id' => 1,
                'status' => true
            ]
        ];
    }
}
