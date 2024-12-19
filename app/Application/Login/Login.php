<?php

namespace App\Application\Login;

use App\Application\Login\DTO\LoginRequestDTO;
use App\Domain\Interfaces\Company\CompanyRepositoryInterface;
use App\Domain\Interfaces\User\UserRepositoryInterface;
use App\Infrastructure\Services\Jwt\JwtAuth;

class Login
{
    public function __construct(
        CompanyRepositoryInterface $companyRepositoryInterface,
        UserRepositoryInterface $userRepositoryInterface,
        JwtAuth $jwtAuth
    ) {}

    public function execute(LoginRequestDTO $input)
    {
        // return [
        //     'company' => $company,
        //     'token' => $jwtToken,
        //     'user' => $user
        // ];
    }
}
