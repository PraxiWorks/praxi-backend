<?php

namespace App\Application\User;

use App\Application\DTO\IdRequestDTO;
use App\Domain\Exceptions\User\UserException;
use App\Domain\Interfaces\User\UserRepositoryInterface;
use App\Models\User\User;

class ShowUser
{

    public function __construct(
        private UserRepositoryInterface $userRepositoryInterface
    ) {}

    public function execute(IdRequestDTO $input): User
    {
        $user = $this->userRepositoryInterface->getById($input->getId());
        if (empty($user)) {
            throw new UserException('Usuário não encontrado', 404);
        }

        return $user;
    }
}
