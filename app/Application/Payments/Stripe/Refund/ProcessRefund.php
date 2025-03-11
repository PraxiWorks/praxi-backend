<?php

namespace App\Application\Payments\Stripe\Refund;

use App\Application\Payments\Stripe\Refund\DTO\ProcessRefundRequestDTO;
use App\Domain\Interfaces\Payments\Stripe\Subscription\StripeSubscriptionRepositoryInterface;
use App\Domain\Service\Payments\Refund\RefundGatewayInterface;
use Exception;

class ProcessRefund
{
    public function __construct(
        private StripeSubscriptionRepositoryInterface $stribeSubscriptionRepositoryInterface,
        private RefundGatewayInterface $refundGatewayInterface
    ) {}

    public function execute(ProcessRefundRequestDTO $input): bool
    {
        try {
            $subscription = $this->stribeSubscriptionRepositoryInterface->getByCompanyId($input->getCompanyId());

            return $this->refundGatewayInterface->refundPayment($subscription, $input->getUserId());
        } catch (Exception $e) {
            throw $e;
        }
    }
}
