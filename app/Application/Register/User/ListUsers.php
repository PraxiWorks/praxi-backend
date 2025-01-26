<?php

namespace App\Application\Register\User;

use App\Application\Register\User\DTO\ListUserRequestDTO;
use App\Domain\Interfaces\Register\User\UserRepositoryInterface;

class ListUsers
{
    public function __construct(
        private UserRepositoryInterface $userRepositoryInterface
    ) {}

    public function execute(ListUserRequestDTO $input): array
    {
        return $this->userRepositoryInterface->list($input);
    }
}
