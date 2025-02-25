<?php

namespace Tests\Application\Register\User;

use App\Application\DTO\IdRequestDTO;
use App\Application\DTO\OutputArrayDTO;
use App\Application\Register\User\Mapper\ShowUserMapper;
use App\Application\Register\User\ShowUser;
use App\Domain\Exceptions\Register\User\UserNotFoundException;
use App\Domain\Interfaces\Register\User\UserRepositoryInterface;
use App\Models\Register\User\User;
use Tests\TestCase;

class ShowUserTest extends TestCase
{
    private UserRepositoryInterface $userRepositoryInterfaceMock;
    private ShowUserMapper $showUserMapperMock;

    private ShowUser $useCase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->userRepositoryInterfaceMock = $this->createMock(UserRepositoryInterface::class);
        $this->showUserMapperMock = $this->createMock(ShowUserMapper::class);

        $this->useCase = new ShowUser(
            $this->userRepositoryInterfaceMock,
            $this->showUserMapperMock
        );
    }

    public function testUserNotFound()
    {
        $this->expectException(UserNotFoundException::class);
        $this->expectExceptionMessage('Usuário não encontrado');

        $input = new IdRequestDTO(1);
        $this->userRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn(null);

        $result = $this->useCase->execute($input);

        $this->assertNull($result);
    }

    public function testExecuteReturnsExpectedUser()
    {
        // Define o valor de retorno esperado do método list
        $user = new User();
        $userMapper = new OutputArrayDTO([
            'id' => 1,
            'company_id' => 1
        ]);

        $input = new IdRequestDTO(1);
        $this->userRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn($user);
        $this->showUserMapperMock->expects($this->once())->method('toOutputDto')->willReturn($userMapper);

        $result = $this->useCase->execute($input);

        // Verifica se o resultado é o esperado
        $this->assertEquals($userMapper, $result);
    }
}
