<?php

namespace App\Infrastructure\Eloquent\Register\User;

use App\Domain\Interfaces\Register\User\UserRepositoryInterface;
use App\Models\Register\User\User;

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

    public function list(int $companyId): array
    {
        return User::where('company_id', $companyId)->get()->toArray();
    }

    public function update(User $entity): bool
    {
        return  $entity->update();
    }

    public function delete(User $entity): bool
    {
        return $entity->delete();
    }

    public function getByEmailAndCompanyId(string $email, int $companyId): ?User
    {
        return User::where('email', $email)
            ->where('company_id', $companyId)
            ->first();
    }

    public function getByUsername(string $userName): ?User
    {
        return User::where('username', $userName)->first();
    }
}
