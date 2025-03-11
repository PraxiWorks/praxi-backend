<?php

namespace App\Application\Payments\Stripe\Subscription;

use App\Application\Payments\Stripe\Customer\DTO\CreateCustomerRequestDTO;
use App\Application\Payments\Stripe\Method\Card\DTO\CreateCardRequestDTO;
use App\Application\Payments\Stripe\Subscription\DTO\CreateSubscriptionRequestDTO;
use App\Application\Payments\Stripe\Subscription\DTO\SubscriptionRequestDTO;
use App\Domain\Service\Payments\Customer\CustomerGatewayInterface;
use App\Domain\Service\Payments\PaymentMethod\Card\CardGatewayInterface;
use App\Domain\Service\Payments\Subscription\SubscriptionGatewayInterface;

class CreateSubscription
{
    public function __construct(
        private CustomerGatewayInterface $customerGatewayInterface,
        private CardGatewayInterface $cardGatewayInterface,
        private SubscriptionGatewayInterface $subscriptionGatewayInterface
    ) {}

    public function execute(SubscriptionRequestDTO $input)
    {
        $inputCustomer = new CreateCustomerRequestDTO(
            $input->getCompanyId(),
            $input->getUserId(),
            $input->getEmail(),
            $input->getName()
        );
        $stripeCustomer = $this->customerGatewayInterface->createCustomer($inputCustomer);

        $inputCard = new CreateCardRequestDTO(
            $input->getCompanyId(),
            $stripeCustomer->id,
            $stripeCustomer->customer_id,
            $input->getCardToken()
        );

        $this->cardGatewayInterface->createCard($inputCard);

        $inputSubscription = new CreateSubscriptionRequestDTO(
            $input->getModule(),
            $input->getCompanyId(),
            $input->getUserId(),
            $stripeCustomer->customer_id,
            $input->getPriceId()
        );

        return $this->subscriptionGatewayInterface->createSubscription($inputSubscription);
    }
}
