<?php

namespace App\Domain\Interfaces\User;

use App\Models\User\UserType;

interface UserTypeRepositoryInterface
{
    public function getById(int $id): ?UserType;
}
