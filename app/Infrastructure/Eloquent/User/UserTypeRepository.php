<?php

namespace App\Infrastructure\Eloquent\User;

use App\Domain\Interfaces\User\UserTypeRepositoryInterface;
use App\Models\User\UserType;

class UserTypeRepository implements UserTypeRepositoryInterface
{
    public function getById(int $id): ?UserType
    {
        return UserType::find($id);
    }
}
