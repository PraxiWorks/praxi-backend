<?php

namespace App\Infrastructure\Services\Payments\Stripe\Customer;

use App\Application\Payments\Stripe\Customer\DTO\CreateCustomerRequestDTO;
use App\Domain\Interfaces\Payments\Stripe\Customer\StripeCustomerRepositoryInterface;
use App\Domain\Service\Payments\Customer\CustomerGatewayInterface;
use App\Models\Payments\Stripe\Customer\StripeCustomer;
use Stripe\Stripe;
use Stripe\Customer;
use Stripe\Exception\ApiErrorException;

class StripeCustomerGateway implements CustomerGatewayInterface
{
    public function __construct(private StripeCustomerRepositoryInterface $stripeCustomerRepositoryInterface) {}

    public function createCustomer(CreateCustomerRequestDTO $input): StripeCustomer
    {
        Stripe::setApiKey(config('services.stripe.secret_key'));

        try {
            // Criar o Cliente no Stripe
            $stripeCustomer = Customer::create([
                'email' => $input->getEmail(),
                'name' => $input->getName(),
            ]);

            $customer = $this->saveResponse($input, $stripeCustomer);

            return $customer;
        } catch (ApiErrorException $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function saveResponse(CreateCustomerRequestDTO $input, object $response)
    {
        $customer = StripeCustomer::new(
            $input->getCompanyId(),
            $input->getUserId(),
            $response->id,
            $input->getEmail(),
            $input->getName()
        );

        $this->stripeCustomerRepositoryInterface->save($customer);

        return $customer;
    }

    // public function showCustomer(string $id): object
    // {
    //     $client = new CustomerClient();
    //     try {
    //         $customer = $client->get($id);

    //         return $customer;
    //     } catch (MPApiException $e) {
    //         throw $e;
    //     }
    // }

    // public function updateCustomer(UpdateCustomerRequestDTO $input): object
    // {
    //     $data = [
    //         'first_name' => $input->getFirstName(),
    //         'last_name'  => $input->getLastName(),
    //     ];
    //     // SALVAR OS DADOS DE RETORNO NO BANCO DE DADOS
    //     $client = new CustomerClient();
    //     try {
    //         $customer = $client->update($input->getId(), $data);

    //         return $customer;
    //     } catch (MPApiException $e) {
    //         throw $e;
    //     }
    // }
}
