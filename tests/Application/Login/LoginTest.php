<?php

namespace Tests\Application\Login;

use App\Application\Login\DTO\LoginRequestDTO;
use App\Application\Login\DTO\LoginResponseDTO;
use App\Application\Login\Login;
use App\Domain\Exceptions\Login\LoginException;
use App\Domain\Exceptions\Register\User\UserException;
use App\Domain\Exceptions\Register\User\UserNotFoundException;
use App\Domain\Interfaces\Core\Company\CompanyRepositoryInterface;
use App\Domain\Interfaces\Register\User\UserRepositoryInterface;
use App\Infrastructure\Services\Jwt\JwtAuth;
use App\Models\Register\User\User;
use Tests\TestCase;

class LoginTest extends TestCase
{
    private CompanyRepositoryInterface $companyRepositoryInterfaceMock;
    private UserRepositoryInterface $userRepositoryInterfaceMock;
    private JwtAuth $jwtAuthMock;

    private Login $useCase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->companyRepositoryInterfaceMock = $this->createMock(CompanyRepositoryInterface::class);
        $this->userRepositoryInterfaceMock = $this->createMock(UserRepositoryInterface::class);
        $this->jwtAuthMock = $this->createMock(JwtAuth::class);


        $this->useCase = new Login(
            $this->companyRepositoryInterfaceMock,
            $this->userRepositoryInterfaceMock,
            $this->jwtAuthMock
        );
    }

    public function testValidateInputThrowsExceptionForUsername()
    {
        $this->expectException(LoginException::class);
        $this->expectExceptionMessage('Nome de usuário não informado');

        $input = new LoginRequestDTO('', 'password');
        $this->useCase->execute($input);
    }

    public function testValidateInputThrowsExceptionForPassword()
    {
        $this->expectException(LoginException::class);
        $this->expectExceptionMessage('Senha não informada');

        $input = new LoginRequestDTO('username', '');
        $this->useCase->execute($input);
    }

    public function testUserNotFound()
    {
        $this->expectException(UserNotFoundException::class);
        $this->expectExceptionMessage('Usuário não encontrado');

        $input = new LoginRequestDTO('username', 'password');
        $this->userRepositoryInterfaceMock->expects($this->once())->method('getByUsername')->willReturn(null);

        $this->useCase->execute($input);
    }

    public function testInvalidPassword()
    {
        $this->expectException(UserException::class);
        $this->expectExceptionMessage('Senha inválida');

        $hashedPassword = password_hash('teste123', PASSWORD_DEFAULT);
        $user = new User();
        $user->password = $hashedPassword;

        $input = new LoginRequestDTO('username', 'password');
        $this->userRepositoryInterfaceMock->expects($this->once())->method('getByUsername')->willReturn($user);

        $this->useCase->execute($input);
    }

    public function testSuccess()
    {
        $hashedPassword = password_hash('password', PASSWORD_DEFAULT);
        $user = new User();
        $user->id = 1;
        $user->password = $hashedPassword;

        $input = new LoginRequestDTO('username', 'password');
        $this->userRepositoryInterfaceMock->expects($this->once())->method('getByUsername')->willReturn($user);

        $jwtToken = 'sample_jwt_token';
        $jwtAuthMock = $this->createMock(JwtAuth::class);
        $jwtAuthMock->method('encode')->willReturn($jwtToken);

        $response = $this->useCase->execute($input);

        $this->assertInstanceOf(LoginResponseDTO::class, $response);
    }
}
