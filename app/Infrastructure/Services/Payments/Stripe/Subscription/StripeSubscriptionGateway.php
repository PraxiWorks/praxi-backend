<?php

namespace App\Infrastructure\Services\Payments\Stripe\Subscription;

use App\Application\Payments\Stripe\Subscription\DTO\CreateSubscriptionRequestDTO;
use App\Domain\Interfaces\Payments\Stripe\Subscription\StripeSubscriptionRepositoryInterface;
use App\Domain\Interfaces\Payments\Stripe\Transaction\StripeTransactionRepositoryInterface;
use App\Domain\Service\Payments\Subscription\SubscriptionGatewayInterface;
use App\Models\Payments\Stripe\Subscription\StripeSubscription;
use App\Models\Payments\Stripe\Transaction\StripeTransaction;
use Stripe\Stripe;
use Stripe\Exception\ApiErrorException;
use Exception;

class StripeSubscriptionGateway implements SubscriptionGatewayInterface
{
    public function __construct(
        private StripeSubscriptionRepositoryInterface $stripeSubscriptionRepositoryInterface,
        private StripeTransactionRepositoryInterface $stripeTransactionRepositoryInterface,
        private StripeSubscriptionService $stripeSubscriptionService,
        private CompanyService $companyService
    ) {}

    public function createSubscription(CreateSubscriptionRequestDTO $input): StripeSubscription
    {
        Stripe::setApiKey(config('services.stripe.secret_key'));

        try {
            $stripeSubscription = $this->stripeSubscriptionService->createStripeSubscription($input);
            $subscription = $this->saveSubscription($input, $stripeSubscription);
            $this->saveTransaction($input, $subscription->id, $stripeSubscription);

            return $subscription;
        } catch (ApiErrorException $e) {
            throw new \Exception($e->getMessage());
        }
    }

    private function saveSubscription(CreateSubscriptionRequestDTO $input, object $stripeSubscription): StripeSubscription
    {
        $subscription = StripeSubscription::new(
            $input->getCompanyId(),
            $input->getUserId(),
            $stripeSubscription->id,
            $stripeSubscription->status,
            now()
        );

        $this->stripeSubscriptionRepositoryInterface->save($subscription);

        return $subscription;
    }

    private function saveTransaction(CreateSubscriptionRequestDTO $input, $subscriptionId, object $stripeSubscription): StripeTransaction
    {
        $transaction = StripeTransaction::new(
            $input->getCompanyId(),
            $input->getUserId(),
            $subscriptionId,
            $stripeSubscription->latest_invoice->payment_intent->id,
            $stripeSubscription->latest_invoice->payment_intent->status,
            $stripeSubscription->latest_invoice->payment_intent->amount
        );

        $this->stripeTransactionRepositoryInterface->save($transaction);

        $this->companyService->updateCompanyTrial($input);

        return $transaction;
    }
}
