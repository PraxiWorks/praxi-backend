<?php

namespace App\Http\Controllers\Register\Client;

use App\Application\DTO\IdRequestDTO;
use App\Application\Register\Client\CreateClient;
use App\Application\Register\Client\DeleteClient;
use App\Application\Register\Client\DTO\CreateClientRequestDTO;
use App\Application\Register\Client\DTO\ListClientRequestDTO;
use App\Application\Register\Client\DTO\UpdateClientRequestDTO;
use App\Application\Register\Client\ListClients;
use App\Application\Register\Client\ShowClient;
use App\Application\Register\Client\UpdateClient;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;

class ClientController extends Controller
{

    public function __construct(
        private CreateClient $createClientUseCase,
        private ShowClient $showClientUseCase,
        private ListClients $listClientUseCase,
        private UpdateClient $updateClientUseCase,
        private DeleteClient $deleteClientUseCase
    ) {}

    public function index(Request $request)
    {
        try {
            $companyId = $request->route('companyId') ?? 0;
            $status = isset($request->status) ? filter_var($request->status, FILTER_VALIDATE_BOOLEAN) : null;
            $searchQuery = $request->search_query ?? null;
            $page = $request->page ?? 1;
            $perPage = $request->per_page ?? 10;

            $input = new ListClientRequestDTO(
                $companyId,
                $status,
                $searchQuery,
                $page,
                $perPage
            );
            $output = $this->listClientUseCase->execute($input);
            return $this->outputSuccessArrayToJson($output, 200);
        } catch (Exception $e) {
            return $this->outputErrorArrayToJson($e->getMessage(), $e->getCode());
        }
    }

    public function store(Request $request)
    {

        $companyId = $request->companyId ?? 0;
        $name = $request->name ?? "";
        $email = $request->email ?? "";
        $phoneNumber = $request->phone_number ?? null;
        $dateOfBirth = $request->date_of_birth ?? null;
        $cpfNumber = $request->cpf_number ?? null;
        $gender = $request->gender ?? null;
        $sendNotificationEmail = $request->send_notification_email ?? false;
        $sendNotificationSms = $request->send_notification_sms ?? false;
        $sendNotificationWhatsapp = $request->send_notification_whatsapp ?? false;
        $imageBase64 = $request->image_base_64 ?? null;
        $hasAccessToTheSystem = $request->has_access_to_the_system ?? false;
        $password = $request->password ?? '';
        $status = $request->status ?? false;

        try {
            $input = new CreateClientRequestDTO(
                $companyId,
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
                $hasAccessToTheSystem,
                $password,
                $status
            );

            $output = $this->createClientUseCase->execute($input);
            return $this->outputSuccessArrayToJson($output, 200);
        } catch (Exception $e) {
            return $this->outputErrorArrayToJson($e->getMessage(), $e->getCode());
        }
    }

    public function show(Request $request)
    {
        $id = $request->clientId ?? 0;
        try {
            $input = new IdRequestDTO($id);
            $output = $this->showClientUseCase->execute($input);
            return $this->outputSuccessArrayToJson($output, 200);
        } catch (Exception $e) {
            return $this->outputErrorArrayToJson($e->getMessage(), $e->getCode());
        }
    }

    public function update(Request $request)
    {
        $id = $request->clientId ?? 0;
        $companyId = $request->companyId ?? 0;
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
        $hasAccessToTheSystem = $request->has_access_to_the_system ?? false;
        $status = $request->status ?? false;

        try {
            $input = new UpdateClientRequestDTO(
                $id,
                $companyId,
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
                $hasAccessToTheSystem,
                $status
            );
            $output = $this->updateClientUseCase->execute($input);
            return $this->outputSuccessArrayToJson($output, 200);
        } catch (Exception $e) {
            return $this->outputErrorArrayToJson($e->getMessage(), $e->getCode());
        }
    }

    public function delete(Request $request)
    {
        $id = $request->clientId ?? 0;
        try {
            $input = new IdRequestDTO($id);
            $output = $this->deleteClientUseCase->execute($input);
            return $this->outputSuccessArrayToJson($output, 200);
        } catch (Exception $e) {
            return $this->outputErrorArrayToJson($e->getMessage(), $e->getCode());
        }
    }
}
