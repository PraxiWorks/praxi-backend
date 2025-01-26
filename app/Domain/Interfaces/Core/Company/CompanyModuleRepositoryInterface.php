<?php

namespace App\Domain\Interfaces\Core\Company;

use App\Models\Core\Company\CompanyModule;

interface CompanyModuleRepositoryInterface
{
    public function save(CompanyModule $entity): bool;
    public function getById(int $id): ?CompanyModule;
    public function list(): array;
    public function update(CompanyModule $entity): bool;
    public function getByCompanyId(int $id): array;
}
