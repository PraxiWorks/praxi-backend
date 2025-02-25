<?php

namespace App\Infrastructure\Eloquent\Register\Client;

use App\Application\Register\Client\DTO\ListClientRequestDTO;
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

    public function list(ListClientRequestDTO $input): array
    {
        $query = Client::where('company_id', $input->getCompanyId());

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

    public function getByCpfAndCompanyId(string $cpf, int $companyId): ?Client
    {
        return Client::where('cpf_number', $cpf)
            ->where('company_id', $companyId)
            ->first();
    }
}
