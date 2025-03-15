<?php

namespace App\Application\Payments\Stripe\Customer\DTO;

class ShowCustomerRequestDTO
{

    public function __construct(
        public string $id,
    ) {}

    public function getId(): string
    {
        return $this->id;
    }
}
