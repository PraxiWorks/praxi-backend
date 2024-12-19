<?php

namespace App\Infrastructure\Eloquent\Company;

use App\Domain\Interfaces\Company\CompanyRepositoryInterface;
use App\Models\Company\Company;

class CompanyRepository implements CompanyRepositoryInterface
{
    public function save(Company $entity): bool
    {
        return $entity->save();
    }

    public function getById(int $id): ?Company
    {
        return Company::find($id);
    }

    public function list(): array
    {
        return Company::get()->toArray();
    }

    public function update(Company $entity): bool
    {
        return $entity->update();
    }

    public function getByName(string $name): ?Company
    {
        return Company::whereRaw("LOWER(unaccent(name)) = LOWER(unaccent(?))", [$name])->first();
    }
}
