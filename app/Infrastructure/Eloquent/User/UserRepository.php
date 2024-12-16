<?php

namespace App\Infrastructure\Eloquent\User;

use App\Domain\Interfaces\User\UserRepositoryInterface;
use App\Models\User\User;

class UserRepository implements UserRepositoryInterface
{
    public function save(User $entity): bool
    {
        return  $entity->save();
    }

    public function getById(int $id): ?User
    {
        return User::find($id);
    }

    public function list(): array
    {
        return User::orderBy('id')->get()->toArray();
    }

    public function update(User $entity): bool
    {
        return  $entity->update();
    }

    public function delete(User $entity): bool
    {
        return $entity->delete();
    }

    public function getByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }
}
