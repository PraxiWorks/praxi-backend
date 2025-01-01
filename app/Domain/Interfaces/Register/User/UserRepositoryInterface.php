<?php

namespace App\Domain\Interfaces\Register\User;

use App\Models\Register\User\User;

interface UserRepositoryInterface
{
    public function save(User $entity): bool;
    public function getById(int $id): ?User;
    public function list(int $companyId): array;
    public function update(User $entity): bool;
    public function delete(User $entity): bool;
    public function getByEmailAndCompanyId(string $email, int $companyId): ?User;
    public function getByUsername(string $username): ?User;
}
