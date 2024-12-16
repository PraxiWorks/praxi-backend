<?php

namespace Tests\Application\User;

use App\Application\DTO\IdRequestDTO;
use App\Application\User\ShowUser;
use App\Domain\Interfaces\User\UserRepositoryInterface;
use App\Models\User\User;
use Tests\TestCase;

class ShowUserTest extends TestCase
{
    private UserRepositoryInterface $userRepositoryInterfaceMock;

    private ShowUser $useCase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->userRepositoryInterfaceMock = $this->createMock(UserRepositoryInterface::class);

        $this->useCase = new ShowUser(
            $this->userRepositoryInterfaceMock
        );
    }

    public function testExecuteReturnsExpectedUser()
    {
        // Define o valor de retorno esperado do método list
        $user = new User();

        $input = new IdRequestDTO(1);
        $this->userRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn($user);

        $result = $this->useCase->execute($input);

        // Verifica se o resultado é o esperado
        $this->assertEquals($user, $result);
    }
}
