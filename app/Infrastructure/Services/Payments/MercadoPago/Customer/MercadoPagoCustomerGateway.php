<?php

namespace App\Infrastructure\Services\Payments\MercadoPago\Customer;

use App\Domain\Interfaces\Http\HttpRepositoryInterface;
use App\Domain\Service\Payments\Customer\CustomerGateway;

class MercadoPagoCustomerGateway implements CustomerGateway
{
    public function __construct(
        private HttpRepositoryInterface $httpRepositoryInterface
    ) {
        $baseUrl = 'https://api.mercadopago.com/v1/customers';
        $this->httpRepositoryInterface->setUrl($baseUrl);

        $header = [
            'Content-Type: application/json',
            'Authorization: Bearer ' . config('payments.mercado_pago.access_token'),

        ];
        $this->httpRepositoryInterface->addHeaders($header);
    }

    public function save($dados)
    {
        return $this->httpRepositoryInterface->post('', $dados);
    }

    public function getById(int $id)
    {
        return $this->httpRepositoryInterface->get("/$id");
    }

    public function update(int $id)
    {
        return $this->httpRepositoryInterface->put("/$id");
    }
}
