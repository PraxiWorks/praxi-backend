<?php

namespace App\Application\User;

use app\Domain\Interfaces\User\UserRepositoryInterface;

class ListUsers
{

    public function __construct(
        private UserRepositoryInterface $userRepositoryInterface
    ) {}

    public function execute(): array
    {
        return $this->userRepositoryInterface->list();
    }
}
