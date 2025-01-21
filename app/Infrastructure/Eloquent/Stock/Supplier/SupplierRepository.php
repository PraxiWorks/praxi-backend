<?php

namespace App\Infrastructure\Eloquent\Stock\Supplier;

use App\Domain\Interfaces\Stock\Supplier\SupplierRepositoryInterface;
use App\Models\Stock\Supplier;

class SupplierRepository implements SupplierRepositoryInterface
{
    public function save(Supplier $entity): bool
    {
        return $entity->save();
    }

    public function getById(int $id): ?Supplier
    {
        return Supplier::find($id);
    }

    public function list(int $empresaId): array
    {
        return Supplier::where('company_id', $empresaId)->get()->toArray();
    }

    public function update(Supplier $entity): bool
    {
        return $entity->save();
    }

    public function delete(Supplier $entity): bool
    {
        return $entity->delete();
    }

    public function getByCnpjNumber(string $cnpjNumber): ?Supplier
    {
        return Supplier::where('cnpj_number', $cnpjNumber)->first();
    }
}
