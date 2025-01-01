<?php

namespace App\Application\Register\User;

use App\Application\DTO\IdRequestDTO;
use App\Domain\Interfaces\Register\User\UserRepositoryInterface;

class ListUsers
{
    public function __construct(
        private UserRepositoryInterface $userRepositoryInterface
    ) {}

    public function execute(IdRequestDTO $input): array
    {
        return $this->userRepositoryInterface->list($input->getId());
    }
}
