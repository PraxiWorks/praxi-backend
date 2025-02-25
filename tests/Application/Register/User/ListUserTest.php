<?php

namespace Tests\Application\Register\User;

use App\Application\DTO\IdRequestDTO;
use App\Application\DTO\OutputArrayDTO;
use App\Application\Register\User\DTO\ListUserRequestDTO;
use App\Application\Register\User\ListUsers;
use App\Application\Register\User\Mapper\ListUsersMapper;
use App\Domain\Interfaces\Register\User\UserRepositoryInterface;
use Tests\TestCase;

class ListUserTest extends TestCase
{
    private UserRepositoryInterface $userRepositoryInterfaceMock;
    private ListUsersMapper $listUsersMapperMock;

    private ListUsers $useCase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->userRepositoryInterfaceMock = $this->createMock(UserRepositoryInterface::class);
        $this->listUsersMapperMock = $this->createMock(ListUsersMapper::class);

        $this->useCase = new ListUsers(
            $this->userRepositoryInterfaceMock,
            $this->listUsersMapperMock
        );
    }

    public function testExecuteReturnsExpectedUserList()
    {
        // Define o valor de retorno esperado do método list
        $users = $this->usersMock();
        $mappedUsers = new OutputArrayDTO($users);

        $input = new ListUserRequestDTO(1, true, 'search', 1, 10);
        $this->userRepositoryInterfaceMock->expects($this->once())->method('list')->willReturn($users);
        $this->listUsersMapperMock->expects($this->once())->method('toOutputDto')->willReturn($mappedUsers);

        $result = $this->useCase->execute($input);

        // Verifica se o resultado é o esperado
        $this->assertEquals($mappedUsers, $result);
    }

    public function usersMock()
    {
        return [
            [
                'id' => 1,
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
                'status' => true
            ],
            [
                'id' => 1,
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
                'status' => true
            ]
        ];
    }
}
