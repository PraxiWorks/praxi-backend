<?php

namespace App\Domain\Interfaces\Company;

use App\Models\Company\Company;

interface CompanyRepositoryInterface
{
    public function save(Company $entity): bool;
    public function getCompanyById(int $id): ?Company;
    public function list(): array;
    public function update(Company $entity): bool;
}
