<?php

namespace App\Domain\Interfaces\User;

use App\Models\User\User;

interface UserRepositoryInterface
{
    public function save(User $entity): bool;
    public function getById(int $id): ?User;
    public function list(): array;
    public function update(User $entity): bool;
    public function delete(User $entity): bool;
    public function getByEmailAndCompanyId(string $email, int $companyId): ?User;
    public function getByUsername(string $username): ?User;
}
