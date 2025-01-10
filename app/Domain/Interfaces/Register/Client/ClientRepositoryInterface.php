<?php

namespace App\Domain\Interfaces\Register\Client;

use App\Models\Register\Client\Client;

interface ClientRepositoryInterface
{
    public function save(Client $entity): bool;
    public function getById(int $id): ?Client;
    public function list(int $companyId): array;
    public function update(Client $entity): bool;
    public function delete(Client $entity): bool;
    public function getByEmailAndCompanyId(string $email, int $companyId): ?Client;
    public function getByCpfAndCompanyId(string $cpf, int $companyId): ?Client;
}
