<?php

namespace App\Application\User;

use App\Application\DTO\IdRequestDTO;
use App\Domain\Interfaces\User\UserRepositoryInterface;

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
