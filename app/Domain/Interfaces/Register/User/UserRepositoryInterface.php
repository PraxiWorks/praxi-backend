<?php

namespace App\Domain\Interfaces\Register\User;

use App\Application\Register\User\DTO\ListUserRequestDTO;
use App\Models\Register\User\User;

interface UserRepositoryInterface
{
    public function save(User $entity): bool;
    public function getById(int $id): ?User;
    public function getByCompanyId(int $companyId): array;
    public function list(ListUserRequestDTO $input): array;
    public function update(User $entity): bool;
    public function delete(User $entity): bool;
    public function getByEmailAndCompanyId(string $email, int $companyId): ?User;
    public function getByUsername(string $username): ?User;
    public function listProfessionalUserByCompanyId(int $companyId): array;
}
