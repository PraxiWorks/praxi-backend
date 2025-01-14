<?php

namespace App\Domain\Service\Payments\Customer;

use App\Application\Payments\Customer\DTO\CreateCustomerRequestDTO;

interface CustomerGateway
{
    public function save(array $dados);
    public function getById(int $id);
    public function update(int $id);
}
