<?php

namespace App\Infrastructure\Services\Payments\Stripe\Method\Card;

use App\Application\Payments\Stripe\Method\Card\DTO\CreateCardRequestDTO;
use App\Domain\Interfaces\Payments\Stripe\Method\Card\StripeCustomerCardRepositoryInterface;
use App\Domain\Service\Payments\PaymentMethod\Card\CardGatewayInterface;
use App\Models\Payments\Stripe\Method\Card\StripeCustomerCard;
use Stripe\Stripe;
use Stripe\Customer;
use Stripe\Exception\ApiErrorException;
use Exception;

class StripeCardGateway implements CardGatewayInterface
{
    public function __construct(
        private StripeCustomerCardRepositoryInterface $stripeCustomerCardRepositoryInterface
    ) {}

    public function createCard(CreateCardRequestDTO $input): StripeCustomerCard
    {
        Stripe::setApiKey(config('services.stripe.secret_key'));

        try {
            $stripeCard = Customer::createSource($input->getCustomerId(), [
                'source' => $input->getCardToken()
            ]);

            $card = $this->saveResponse($input->getStripeCustomerId(), $stripeCard);

            return $card;
        } catch (ApiErrorException $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function saveResponse(int $stripeCustomerId, object $response)
    {
        $stripeCustomerCard = StripeCustomerCard::new(
            $stripeCustomerId,
            $response->id,
            $response->last4,
            $response->exp_month,
            $response->exp_year
        );
        if (!$this->stripeCustomerCardRepositoryInterface->save($stripeCustomerCard)) {
            throw new \Exception('Error saving customer');
        }

        return $stripeCustomerCard;
    }
}
