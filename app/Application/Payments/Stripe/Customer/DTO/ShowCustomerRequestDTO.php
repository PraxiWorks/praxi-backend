<?php

namespace App\Application\Payments\MercadoPago\Customer\DTO;

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
