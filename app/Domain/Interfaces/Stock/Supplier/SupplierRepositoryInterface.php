<?php

namespace App\Domain\Interfaces\Stock\Supplier;

use App\Models\Stock\Supplier;

interface SupplierRepositoryInterface
{
    public function save(Supplier $entity): bool;
    public function getById(int $id): ?Supplier;
    public function list(int $empresaId): array;
    public function update(Supplier $entity): bool;
    public function delete(Supplier $entity): bool;
    public function getByCnpjNumber(string $cnpjNumber): ?Supplier;
}
