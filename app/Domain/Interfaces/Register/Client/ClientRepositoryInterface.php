<?php

namespace App\Domain\Interfaces\Register\Client;

use App\Application\Register\Client\DTO\ListClientRequestDTO;
use App\Models\Register\Client\Client;

interface ClientRepositoryInterface
{
    public function save(Client $entity): bool;
    public function getById(int $id): ?Client;
    public function list(ListClientRequestDTO $input): array;
    public function update(Client $entity): bool;
    public function delete(Client $entity): bool;
    public function getByEmailAndCompanyId(string $email, int $companyId): ?Client;
    public function getByCpfAndCompanyId(string $cpf, int $companyId): ?Client;
}
