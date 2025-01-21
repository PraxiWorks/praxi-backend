<?php

namespace App\Application\Login;

use App\Application\Login\DTO\LoginRequestDTO;
use App\Application\Login\DTO\LoginResponseDTO;
use App\Domain\Exceptions\Login\LoginException;
use App\Domain\Exceptions\Register\User\UserException;
use App\Domain\Exceptions\Register\User\UserNotFoundException;
use App\Domain\Interfaces\Core\Company\CompanyRepositoryInterface;
use App\Domain\Interfaces\Register\User\UserRepositoryInterface;
use App\Infrastructure\Services\Jwt\JwtAuth;

class Login
{
    public function __construct(
        private CompanyRepositoryInterface $companyRepositoryInterface,
        private UserRepositoryInterface $userRepositoryInterface,
        private JwtAuth $jwtAuth
    ) {}

    public function execute(LoginRequestDTO $input): LoginResponseDTO
    {
        $this->validateInput($input);

        $user = $this->userRepositoryInterface->getByUsername($input->getUsername());
        if (empty($user)) {
            throw new UserNotFoundException('Usuário não encontrado', 404);
        }

        if (!password_verify($input->getPassword(), $user->password)) {
            throw new UserException('Senha inválida', 400);
        }

        $data = [
            'user_id' => $user->id,
            'company_id' => $user->company_id,
        ];

        $jwtToken = $this->jwtAuth->encode($data, config('jwtAuth.expirationTime'));

        return new LoginResponseDTO($jwtToken);
    }

    private function validateInput(LoginRequestDTO $input): void
    {
        if (empty($input->getUsername())) {
            throw new LoginException('Nome de usuário não informado', 400);
        }

        if (empty($input->getPassword())) {
            throw new LoginException('Senha não informada', 400);
        }
    }
}
