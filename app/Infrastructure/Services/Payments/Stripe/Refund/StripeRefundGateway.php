<?php

namespace App\Infrastructure\Services\Payments\Stripe\Refund;

use App\Domain\Interfaces\Payments\Stripe\Refund\StripeRefundRepositoryInterface;
use App\Domain\Interfaces\Payments\Stripe\Subscription\StripeSubscriptionRepositoryInterface;
use App\Domain\Interfaces\Payments\Stripe\Transaction\StripeTransactionRepositoryInterface;
use App\Domain\Service\Payments\Refund\RefundGatewayInterface;
use App\Models\Payments\Stripe\Refund\StripeRefund;
use App\Models\Payments\Stripe\Subscription\StripeSubscription;
use Stripe\Stripe;
use Stripe\Subscription;
use Stripe\Refund;
use Stripe\Invoice;
use Stripe\Exception\ApiErrorException;
use Exception;

class StripeRefundGateway implements RefundGatewayInterface
{
    public function __construct(
        private StripeRefundRepositoryInterface $stripeRefundRepositoryInterface,
        private StripeTransactionRepositoryInterface $stripeTransactionRepositoryInterface,
        private StripeSubscriptionRepositoryInterface $stripeSubscriptionRepositoryInterface
    ) {}

    public function refundPayment(StripeSubscription $stribeSubscription, int $userId): bool
    {
        Stripe::setApiKey(config('services.stripe.secret_key'));

        try {
            $subscription = Subscription::retrieve($stribeSubscription->subscription_id);
            $createdTimestamp = $subscription->created;
            $currentTimestamp = time();

            $daysSinceSubscription = ($currentTimestamp - $createdTimestamp) / (60 * 60 * 24);

            $refundEligible = $daysSinceSubscription < 7;

            if ($refundEligible) {
                $latestInvoice = $subscription->latest_invoice;
                $invoice = Invoice::retrieve($latestInvoice);
                $paymentIntent = $invoice->payment_intent;

                if ($paymentIntent) {
                    $refund = Refund::create([
                        'payment_intent' => $paymentIntent,
                    ]);

                    $refundStatus = $refund->status;
                } else {
                    $refundStatus = "no_payment_found";
                }
            } else {
                $refundStatus = "not_eligible";
            }

            $subscription->cancel();

            $this->saveResponse($stribeSubscription, $refund, $refundStatus, $userId);
            $this->updateSubscription($stribeSubscription, $subscription->status);

            return true;
        } catch (ApiErrorException $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function saveResponse($stribeSubscription, object $response, string $refundStatus, int $userId): void
    {

        $transaction = $this->stripeTransactionRepositoryInterface->getBySubscriptionId($stribeSubscription->id);

        $amountInReais = $response->amount / 100;

        $subscription = StripeRefund::new(
            $stribeSubscription->company_id,
            $userId,
            $transaction->id,
            $response->id,
            $amountInReais,
            $refundStatus
        );

        $this->stripeRefundRepositoryInterface->save($subscription);
    }

    public function updateSubscription(StripeSubscription $subscription, $updatedStatus): void
    {
        $subscription->status = $updatedStatus;

        $this->stripeSubscriptionRepositoryInterface->update($subscription);
    }
}
