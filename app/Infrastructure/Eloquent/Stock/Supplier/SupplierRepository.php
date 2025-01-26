<?php

namespace App\Infrastructure\Eloquent\Stock\Supplier;

use App\Application\Stock\Supplier\DTO\ListSupplierRequestDTO;
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

    public function list(ListSupplierRequestDTO $input): array
    {
        $query = Supplier::where('company_id', $input->getCompanyId());

        if (!empty($input->getStatus())) {
            $query->where('status', $input->getStatus());
        }

        $query->orderBy('id', 'desc');

        return $query->get()->toArray();
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
