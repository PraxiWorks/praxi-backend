<?php

namespace App\Application\User;

use App\Application\DTO\IdRequestDTO;
use App\Domain\Exceptions\User\UserException;
use app\Domain\Interfaces\User\UserRepositoryInterface;
use App\Models\User\User;

class ShowUser
{
    private UserRepositoryInterface $userRepositoryInterface;

    public function __construct(
        UserRepositoryInterface $userRepositoryInterface
    ) {
        $this->userRepositoryInterface = $userRepositoryInterface;
    }

    public function execute(IdRequestDTO $input): User
    {
        $user = $this->userRepositoryInterface->getById($input->getId());
        if (empty($user)) {
            throw new UserException('Usuário não encontrado', 404);
        }

        return $user;
    }
}
