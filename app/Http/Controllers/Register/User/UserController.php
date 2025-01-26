<?php

namespace App\Http\Controllers\Register\User;

use App\Application\DTO\IdRequestDTO;
use App\Application\Register\User\CreateUser;
use App\Application\Register\User\DeleteUser;
use App\Application\Register\User\DTO\CreateUserRequestDTO;
use App\Application\Register\User\DTO\ListUserRequestDTO;
use App\Application\Register\User\DTO\UpdateUserRequestDTO;
use App\Application\Register\User\ListProfessionalUser;
use App\Application\Register\User\ListUsers;
use App\Application\Register\User\ShowUser;
use App\Application\Register\User\UpdateUser;
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
        private DeleteUser $deleteUserUseCase,
        private ListProfessionalUser $listProfessionalUserUseCase
    ) {}

    public function index(Request $request)
    {
        try {
            $companyId = $request->route('companyId') ?? 0;
            $status = $request->status ?? '';

            $input = new ListUserRequestDTO(
                $companyId,
                $status
            );
            $output = $this->listUserUseCase->execute($input);
            return $this->outputSuccessArrayToJson($output, 200);
        } catch (Exception $e) {
            return $this->outputErrorArrayToJson($e->getMessage(), $e->getCode());
        }
    }

    public function store(Request $request)
    {

        $companyId = $request->companyId ?? 0;
        $username = $request->username ?? null;
        $name = $request->name ?? null;
        $email = $request->email ?? null;
        $phoneNumber = $request->phone_number ?? null;
        $dateOfBirth = $request->date_of_birth ?? null;
        $cpfNumber = $request->cpf_number ?? null;
        $gender = $request->gender ?? null;
        $sendNotificationEmail = $request->send_notification_email ?? false;
        $sendNotificationSms = $request->send_notification_sms ?? false;
        $sendNotificationWhatsapp = $request->send_notification_whatsapp ?? false;
        $imageBase64 = $request->image_base_64 ?? null;
        $password = $request->password ?? 'teste123';
        $isProfessional = $request->is_professional ?? false;
        $groupId = $request->group_id ?? null;
        $status = $request->status ?? false;

        try {
            $input = new CreateUserRequestDTO(
                $companyId,
                $username,
                $name,
                $email,
                $phoneNumber,
                $dateOfBirth,
                $cpfNumber,
                $gender,
                $sendNotificationEmail,
                $sendNotificationSms,
                $sendNotificationWhatsapp,
                $imageBase64,
                $password,
                $isProfessional,
                $groupId,
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
        $username = $request->username ?? null;
        $name = $request->name ?? null;
        $email = $request->email ?? null;
        $phoneNumber = $request->phone_number ?? null;
        $dateOfBirth = $request->date_of_birth ?? null;
        $cpfNumber = $request->cpf_number ?? null;
        $gender = $request->gender ?? null;
        $sendNotificationEmail = $request->send_notification_email ?? false;
        $sendNotificationSms = $request->send_notification_sms ?? false;
        $sendNotificationWhatsapp = $request->send_notification_whatsapp ?? false;
        $imageBase64 = $request->image_base_64 ?? null;
        $isProfessional = $request->is_professional ?? false;
        $groupId = $request->group_id ?? null;
        $status = $request->status ?? false;

        try {
            $input = new UpdateUserRequestDTO(
                $id,
                $companyId,
                $username,
                $name,
                $email,
                $phoneNumber,
                $dateOfBirth,
                $cpfNumber,
                $gender,
                $sendNotificationEmail,
                $sendNotificationSms,
                $sendNotificationWhatsapp,
                $imageBase64,
                $isProfessional,
                $groupId,
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

    public function professionals(Request $request)
    {
        try {
            $companyId = $request->route('companyId') ?? 0;
            $input = new IdRequestDTO($companyId);
            $output = $this->listProfessionalUserUseCase->execute($input);
            return $this->outputSuccessArrayToJson($output, 200);
        } catch (Exception $e) {
            return $this->outputErrorArrayToJson($e->getMessage(), $e->getCode());
        }
    }
}
