<?php

namespace App\Infrastructure\Eloquent\Register\ClientAddress;

use App\Domain\Interfaces\Register\ClientAddress\ClientAddressRepositoryInterface;
use App\Models\Register\ClientAddress\ClientAddress;

class ClientAddressRepository implements ClientAddressRepositoryInterface
{
    public function save(ClientAddress $entity): bool
    {
        return  $entity->save();
    }

    public function getById(int $id): ?ClientAddress
    {
        return ClientAddress::find($id);
    }

    public function list(int $companyId): array
    {
        return ClientAddress::where('company_id', $companyId)->get()->toArray();
    }

    public function update(ClientAddress $entity): bool
    {
        return  $entity->update();
    }

    public function delete(ClientAddress $entity): bool
    {
        return $entity->delete();
    }

    public function getByClientId(int $clientId): ?ClientAddress
    {
        return ClientAddress::where('client_id', $clientId)->first();
    }
}
