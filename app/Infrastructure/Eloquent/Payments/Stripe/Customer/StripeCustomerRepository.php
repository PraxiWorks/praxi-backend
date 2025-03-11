<?php

namespace App\Infrastructure\Eloquent\Payments\Stripe\Customer;

use App\Domain\Interfaces\Payments\Stripe\Customer\StripeCustomerRepositoryInterface;
use App\Models\Payments\Stripe\Customer\StripeCustomer;

class StripeCustomerRepository implements StripeCustomerRepositoryInterface
{
    public function save(StripeCustomer $entity): bool
    {
        return $entity->save();
    }

    public function getById(int $id): StripeCustomer
    {
        return StripeCustomer::findOrFail($id);
    }

    // public function list(ListMercadoPagoCustomerRequestDTO $input): array
    // {
    //     $query = MercadoPagoCustomer::where('company_id', $input->getCompanyId());

    //     if ($input->getStatus() !== null) {
    //         $query->where('status', $input->getStatus());
    //     }

    //     if (!empty($input->getSearchQuery())) {
    //         $query->where('name', 'like', '%' . $input->getSearchQuery() . '%');
    //     }

    //     $query->orderBy('id', 'desc');

    //     $paginatedData = $query->paginate($input->getPerPage(), ['*'], 'page', $input->getPage());
    //     return $paginatedData->toArray();
    // }
}
