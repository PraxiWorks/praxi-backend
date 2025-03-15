<?php

namespace App\Http\Controllers\Payments\Stripe\Card;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;

class CardController extends Controller
{

    public function __construct(
        // private ShowCustomer $showCustomerUseCase,
        // private UpdateCustomer $updateCustomerUseCase
    ) {}

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
