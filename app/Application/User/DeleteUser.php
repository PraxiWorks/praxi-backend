<?php

namespace App\Application\User;

use App\Application\DTO\IdRequestDTO;
use App\Domain\Exceptions\User\UserException;
use App\Domain\Exceptions\User\UserNotFoundException;
use app\Domain\Interfaces\User\UserRepositoryInterface;

class DeleteUser
{
    private UserRepositoryInterface $userRepositoryInterface;

    public function __construct(
        UserRepositoryInterface $userRepositoryInterface
    ) {
        $this->userRepositoryInterface = $userRepositoryInterface;
    }

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
