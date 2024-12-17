<?php

namespace App\Http\Controllers\User;

use App\Application\DTO\IdRequestDTO;
use App\Application\User\CreateUser;
use App\Application\User\DeleteUser;
use App\Application\User\DTO\CreateUserRequestDTO;
use App\Application\User\DTO\UpdateUserRequestDTO;
use App\Application\User\ListUsers;
use App\Application\User\ShowUser;
use App\Application\User\UpdateUser;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function __construct(
        private CreateUser $createUserUseCase,
        private ShowUser $showUserUseCase,
        private ListUsers $listUserUseCase,
        private UpdateUser $updateUserUseCase,
        private DeleteUser $deleteUserUseCase
    ) {}

    public function index()
    {
        try {
            $output = $this->listUserUseCase->execute();
            return $this->outputSuccessArrayToJson($output, 200);
        } catch (Exception $e) {
            return $this->outputErrorArrayToJson($e->getMessage(), $e->getCode());
        }
    }

    public function store(Request $request)
    {

        $companyId = $request->companyId ?? 0;
        $name = $request->name ?? null;
        $email = $request->email ?? null;
        $phoneNumber = $request->phone_number ?? null;
        $userTypeId = $request->user_type_id ?? 0;
        $dateOfBirth = $request->date_of_birth ?? null;
        $cpfNumber = $request->cpf_number ?? null;
        $rgNumber = $request->rg_number ?? null;
        $gender = $request->gender ?? null;
        $sendNotificationEmail = $request->send_notification_email ?? false;
        $sendNotificationSms = $request->send_notification_sms ?? false;
        $sendNotificationWhatsapp = $request->send_notification_whatsapp ?? false;
        $imageBase64 = $request->image_base_64 ?? null;
        $password = $request->password ?? 'teste123';
        $status = $request->status ?? false;

        try {
            $input = new CreateUserRequestDTO(
                $companyId,
                $name,
                $email,
                $phoneNumber,
                $userTypeId,
                $dateOfBirth,
                $cpfNumber,
                $rgNumber,
                $gender,
                $sendNotificationEmail,
                $sendNotificationSms,
                $sendNotificationWhatsapp,
                $imageBase64,
                $password,
                $status
            );
            $output = $this->createUserUseCase->execute($input);
            return $this->outputSuccessArrayToJson($output, 200);
        } catch (Exception $e) {
            return $this->outputErrorArrayToJson($e->getMessage(), $e->getCode());
        }
    }

    public function show(Request $request)
    {
        $id = $request->userId ?? 0;
        try {
            $input = new IdRequestDTO($id);
            $output = $this->showUserUseCase->execute($input);
            return $this->outputSuccessArrayToJson($output, 200);
        } catch (Exception $e) {
            return $this->outputErrorArrayToJson($e->getMessage(), $e->getCode());
        }
    }


    public function update(Request $request)
    {
        $id = $request->userId ?? 0;
        $companyId = $request->companyId ?? 0;
        $name = $request->name ?? null;
        $email = $request->email ?? null;
        $phoneNumber = $request->phone_number ?? null;
        $userTypeId = $request->user_type_id ?? 0;
        $dateOfBirth = $request->date_of_birth ?? null;
        $cpfNumber = $request->cpf_number ?? null;
        $rgNumber = $request->rg_number ?? null;
        $gender = $request->gender ?? null;
        $sendNotificationEmail = $request->send_notification_email ?? false;
        $sendNotificationSms = $request->send_notification_sms ?? false;
        $sendNotificationWhatsapp = $request->send_notification_whatsapp ?? false;
        $imageBase64 = $request->image_base_64 ?? null;
        $status = $request->status ?? false;

        try {
            $input = new UpdateUserRequestDTO(
                $id,
                $companyId,
                $name,
                $email,
                $phoneNumber,
                $userTypeId,
                $dateOfBirth,
                $cpfNumber,
                $rgNumber,
                $gender,
                $sendNotificationEmail,
                $sendNotificationSms,
                $sendNotificationWhatsapp,
                $imageBase64,
                $status
            );
            $output = $this->updateUserUseCase->execute($input);
            return $this->outputSuccessArrayToJson($output, 200);
        } catch (Exception $e) {
            return $this->outputErrorArrayToJson($e->getMessage(), $e->getCode());
        }
    }

    public function delete(Request $request)
    {
        $id = $request->userId ?? 0;
        try {
            $input = new IdRequestDTO($id);
            $output = $this->deleteUserUseCase->execute($input);
            return $this->outputSuccessArrayToJson($output, 200);
        } catch (Exception $e) {
            return $this->outputErrorArrayToJson($e->getMessage(), $e->getCode());
        }
    }
}
