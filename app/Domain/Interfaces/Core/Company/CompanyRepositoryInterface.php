<?php

namespace App\Domain\Interfaces\Core\Company;

use App\Models\Core\Company\Company;

interface CompanyRepositoryInterface
{
    public function save(Company $entity): bool;
    public function getById(int $id): ?Company;
    public function list(): array;
    public function update(Company $entity): bool;
    public function getByName(string $name): ?Company;
}
