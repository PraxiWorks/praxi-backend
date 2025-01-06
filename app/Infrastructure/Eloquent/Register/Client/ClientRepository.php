<?php

namespace App\Infrastructure\Eloquent\Register\Client;

use App\Domain\Interfaces\Register\Client\ClientRepositoryInterface;
use App\Models\Register\Client\Client;

class ClientRepository implements ClientRepositoryInterface
{
    public function save(Client $entity): bool
    {
        return  $entity->save();
    }

    public function getById(int $id): ?Client
    {
        return Client::find($id);
    }

    public function list(int $companyId): array
    {
        return Client::where('company_id', $companyId)->get()->toArray();
    }

    public function update(Client $entity): bool
    {
        return  $entity->update();
    }

    public function delete(Client $entity): bool
    {
        return $entity->delete();
    }

    public function getByEmailAndCompanyId(string $email, int $companyId): ?Client
    {
        return Client::where('email', $email)
            ->where('company_id', $companyId)
            ->first();
    }
}
