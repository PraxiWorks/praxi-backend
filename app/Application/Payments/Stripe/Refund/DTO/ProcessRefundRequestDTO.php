<?php

namespace App\Application\Payments\Stripe\Refund\DTO;

class ProcessRefundRequestDTO
{
    public function __construct(
        public int $companyId,
        public int $userId
    ) {}

    public function getCompanyId(): int
    {
        return $this->companyId;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }
}
