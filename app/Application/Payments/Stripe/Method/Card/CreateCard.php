<?php

namespace App\Application\Payments\MercadoPago\Method\Card;

use App\Application\Payments\Stripe\Method\Card\DTO\CreateCardRequestDTO;
use App\Domain\Service\Payments\PaymentMethod\Card\CardGatewayInterface;
use Exception;

class CreateCard
{
    public function __construct(private CardGatewayInterface $cardGatewayInterface) {}

    public function execute(CreateCardRequestDTO $input)
    {
        try {
            return $this->cardGatewayInterface->createCard($input);
        } catch (Exception $e) {
            throw $e;
        }
    }
}
