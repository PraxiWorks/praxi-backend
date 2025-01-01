<?php

namespace App\Application\Register\User;

use App\Application\DTO\IdRequestDTO;
use App\Domain\Exceptions\Register\User\UserException;
use App\Domain\Exceptions\Register\User\UserNotFoundException;
use App\Domain\Interfaces\Register\User\UserRepositoryInterface;

class DeleteUser
{

    public function __construct(
        private UserRepositoryInterface $userRepositoryInterface
    ) {}

    public function execute(IdRequestDTO $input): bool
    {

        $user = $this->userRepositoryInterface->getById($input->getId());
        if (empty($user)) {
            throw new UserNotFoundException('Usuário não encontrado', 400);
        }

        if (!$this->userRepositoryInterface->delete($user)) {
            throw new UserException('Erro ao deletar usuário', 400);
        }

        return true;
    }
}
