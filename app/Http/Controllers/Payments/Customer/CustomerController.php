<?php

namespace App\Http\Controllers\Payments\Customer;

use App\Application\Payments\Customer\CreateCustomer;
use App\Application\Payments\Customer\DTO\CreateCustomerRequestDTO;
use App\Http\Controllers\Controller;
use DateTime;
use Exception;
use Illuminate\Http\Request;

class CustomerController extends Controller
{

    public function __construct(
        private CreateCustomer $createCustomerUseCase,
        // private ShowCustomer $showCustomerUseCase,
        // private UpdateCustomer $updateCustomerUseCase
    ) {}

    public function store(Request $request)
    {
        $date = new DateTime($request->date_registered);

        $email = $request->email ?? '';
        $firstName = $request->first_name ?? null;
        $lastName = $request->last_name ?? null;
        $phone = $request->phone ?? null;
        $indentification = $request->identification ?? null;
        $defaultAddress = $request->default_address ?? null;
        $address = $request->address ?? null;
        $dateRegistered = $date ? $date->format(DateTime::ATOM) ?? null : null;
        $description = $request->description ?? null;
        $defaultCard = $request->default_card ?? null;


        try {
            $input = new CreateCustomerRequestDTO(
                $email,
                $firstName,
                $lastName,
                $phone,
                $indentification,
                $defaultAddress,
                $address,
                $dateRegistered,
                $description,
                $defaultCard
            );
            $output = $this->createCustomerUseCase->execute($input);
            return $this->outputSuccessArrayToJson($output, 200);
        } catch (Exception $e) {
            return $this->outputErrorArrayToJson($e->getMessage(), $e->getCode());
        }
    }

    // public function show(Request $request)
    // {
    //     $id = $request->clientId ?? 0;
    //     try {
    //         $input = new IdRequestDTO($id);
    //         $output = $this->showClientUseCase->execute($input);
    //         return $this->outputSuccessArrayToJson($output, 200);
    //     } catch (Exception $e) {
    //         return $this->outputErrorArrayToJson($e->getMessage(), $e->getCode());
    //     }
    // }

    // public function update(Request $request)
    // {
    //     $id = $request->clientId ?? 0;
    //     $companyId = $request->companyId ?? 0;
    //     $name = $request->name ?? null;
    //     $email = $request->email ?? null;
    //     $phoneNumber = $request->phone_number ?? null;
    //     $dateOfBirth = $request->date_of_birth ?? null;
    //     $cpfNumber = $request->cpf_number ?? null;
    //     $rgNumber = $request->rg_number ?? null;
    //     $gender = $request->gender ?? null;
    //     $sendNotificationEmail = $request->send_notification_email ?? false;
    //     $sendNotificationSms = $request->send_notification_sms ?? false;
    //     $sendNotificationWhatsapp = $request->send_notification_whatsapp ?? false;
    //     $imageBase64 = $request->image_base_64 ?? null;
    //     $hasAccessToTheSystem = $request->has_access_to_the_system ?? false;
    //     $status = $request->status ?? false;

    //     try {
    //         $input = new UpdateClientRequestDTO(
    //             $id,
    //             $companyId,
    //             $name,
    //             $email,
    //             $phoneNumber,
    //             $dateOfBirth,
    //             $cpfNumber,
    //             $rgNumber,
    //             $gender,
    //             $sendNotificationEmail,
    //             $sendNotificationSms,
    //             $sendNotificationWhatsapp,
    //             $imageBase64,
    //             $hasAccessToTheSystem,
    //             $status
    //         );
    //         $output = $this->updateClientUseCase->execute($input);
    //         return $this->outputSuccessArrayToJson($output, 200);
    //     } catch (Exception $e) {
    //         return $this->outputErrorArrayToJson($e->getMessage(), $e->getCode());
    //     }
    // }
}
