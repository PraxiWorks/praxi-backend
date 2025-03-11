<?php

namespace App\Infrastructure\Eloquent\Payments\Stripe\Method\Card;

use App\Domain\Interfaces\Payments\Stripe\Method\Card\StripeCustomerCardRepositoryInterface;
use App\Models\Payments\Stripe\Method\Card\StripeCustomerCard;

class StripeCustomerCardRepository implements StripeCustomerCardRepositoryInterface
{
    public function save(StripeCustomerCard $entity): bool
    {
        return $entity->save();
    }

    public function getById(int $id): StripeCustomerCard
    {
        return StripeCustomerCard::findOrFail($id);
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
