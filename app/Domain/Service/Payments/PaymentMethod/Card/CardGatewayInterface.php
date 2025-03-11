<?php

namespace App\Domain\Service\Payments\PaymentMethod\Card;

use App\Application\Payments\Stripe\Method\Card\DTO\CreateCardRequestDTO;
use App\Models\Payments\Stripe\Method\Card\StripeCustomerCard;

interface CardGatewayInterface
{
    public function createCard(CreateCardRequestDTO $input): StripeCustomerCard;
}
