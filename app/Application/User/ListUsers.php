<?php

namespace App\Application\User;

use app\Domain\Interfaces\User\UserRepositoryInterface;

class ListUsers
{
    private UserRepositoryInterface $userRepositoryInterface;

    public function __construct(
        UserRepositoryInterface $userRepositoryInterface
    ) {
        $this->userRepositoryInterface = $userRepositoryInterface;
    }

    public function execute(): array
    {
        return $this->userRepositoryInterface->list();
    }
}
