<?php

namespace App\Application\Register\User;

use App\Application\DTO\IdRequestDTO;
use App\Domain\Exceptions\Register\User\UserNotFoundException;
use App\Domain\Interfaces\Register\User\UserRepositoryInterface;
use App\Models\Register\User\User;

class ShowUser
{

    public function __construct(
        private UserRepositoryInterface $userRepositoryInterface
    ) {}

    public function execute(IdRequestDTO $input): User
    {
        $user = $this->userRepositoryInterface->getById($input->getId());
        if (empty($user)) {
            throw new UserNotFoundException('Usuário não encontrado', 404);
        }

        return $user;
    }
}
