<?php

namespace App\Infrastructure\Eloquent\Register\User;

use App\Application\Register\User\DTO\ListUserRequestDTO;
use App\Domain\Interfaces\Register\User\UserRepositoryInterface;
use App\Models\Register\User\User;

class UserRepository implements UserRepositoryInterface
{
    public function save(User $entity): bool
    {
        return  $entity->save();
    }

    public function getById(int $id): ?User
    {
        return User::find($id);
    }

    public function list(ListUserRequestDTO $input): array
    {
        $query = User::where('company_id', $input->getCompanyId());

        if ($input->getStatus() !== null) {
            $query->where('status', $input->getStatus());
        }

        if (!empty($input->getSearchQuery())) {
            $query->where('name', 'like', '%' . $input->getSearchQuery() . '%');
        }

        $query->orderBy('id', 'desc');

        $paginatedData = $query->paginate($input->getPerPage(), ['*'], 'page', $input->getPage());
        return $paginatedData->toArray();
    }

    public function update(User $entity): bool
    {
        return  $entity->update();
    }

    public function delete(User $entity): bool
    {
        return $entity->delete();
    }

    public function getByEmailAndCompanyId(string $email, int $companyId): ?User
    {
        return User::where('email', $email)
            ->where('company_id', $companyId)
            ->first();
    }

    public function getByUsername(string $userName): ?User
    {
        return User::where('username', $userName)->first();
    }

    public function listProfessionalUserByCompanyId(int $companyId): array
    {
        return User::where('company_id', $companyId)
            ->where('is_professional', true)
            ->get()
            ->toArray();
    }
}
