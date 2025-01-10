<?php

namespace App\Domain\Interfaces\Register\ClientAddress;

use App\Models\Register\ClientAddress\ClientAddress;

interface ClientAddressRepositoryInterface
{
    public function save(ClientAddress $entity): bool;
    public function getById(int $id): ?ClientAddress;
    public function list(int $companyId): array;
    public function update(ClientAddress $entity): bool;
    public function delete(ClientAddress $entity): bool;
    public function getByClientId(int $clientId): ?ClientAddress;
}
