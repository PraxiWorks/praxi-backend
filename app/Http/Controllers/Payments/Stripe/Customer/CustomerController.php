<?php

namespace App\Http\Controllers\Payments\Stripe\Customer;

use App\Application\Payments\Stripe\Customer\CreateCustomer;
use App\Application\Payments\Stripe\Customer\DTO\CreateCustomerRequestDTO;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{

    public function __construct(
        private CreateCustomer $createCustomerUseCase,
        // private ListCustomers $listCustomersUseCase,
        // private ShowCustomer $showCustomerUseCase,
        // private UpdateCustomer $updateCustomerUseCase
    ) {}

    public function store(Request $request)
    {
        $companyId = $request->route('companyId') ?? 0;
        $userId = Auth::user()->id ?? 0;
        $email = $request->email ?? null;
        $name = $request->name ?? null;

        try {
            $input = new CreateCustomerRequestDTO(
                $companyId,
                $userId,
                $email,
                $name
            );
            $output = $this->createCustomerUseCase->execute($input);
            return $this->outputSuccessArrayToJson($output, 200);
        } catch (Exception $e) {
            dd($e);
            $statusCode = $e->getCode() > 0 ? $e->getCode() : 500;
            return $this->outputErrorArrayToJson($e->getMessage(), $statusCode);
        }
    }

    // public function show(Request $request)
    // {
    //     $id = $request->customerId ?? 0;
    //     try {
    //         $input = new ShowCustomerRequestDTO($id);
    //         $output = $this->showCustomerUseCase->execute($input);
    //         return $this->outputSuccessArrayToJson($output, 200);
    //     } catch (Exception $e) {
    //         $statusCode = $e->getCode() > 0 ? $e->getCode() : 500;
    //         return $this->outputErrorArrayToJson($e->getMessage(), $statusCode);
    //     }
    // }

    // public function update(Request $request)
    // {
    //     $id = $request->customerId ?? 0;
    //     $firstName = $request->first_name ?? null;
    //     $lastName = $request->last_name ?? null;

    //     try {
    //         $input = new UpdateCustomerRequestDTO(
    //             $id,
    //             $firstName,
    //             $lastName
    //         );
    //         $output = $this->updateCustomerUseCase->execute($input);
    //         return $this->outputSuccessArrayToJson($output, 200);
    //     } catch (Exception $e) {
    //         $statusCode = $e->getCode() > 0 ? $e->getCode() : 500;
    //         return $this->outputErrorArrayToJson($e->getMessage(), $statusCode);
    //     }
    // }
}
