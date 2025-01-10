<?php

namespace App\Http\Controllers\Register\ClientAddress;

use App\Application\DTO\IdRequestDTO;
use App\Application\Register\ClientAddress\CreateClientAddress;
use App\Application\Register\ClientAddress\DeleteClientAddress;
use App\Application\Register\ClientAddress\DTO\CreateClientAddressRequestDTO;
use App\Application\Register\ClientAddress\DTO\UpdateClientAddressRequestDTO;
use App\Application\Register\ClientAddress\ListClientAddress;
use App\Application\Register\ClientAddress\ShowClientAddress;
use App\Application\Register\ClientAddress\UpdateClientAddress;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;

class ClientAddressController extends Controller
{

    public function __construct(
        private CreateClientAddress $createClientAddressUseCase,
        private ShowClientAddress $showClientAddressUseCase,
        private ListClientAddress $listClientAddressUseCase,
        private UpdateClientAddress $updateClientAddressUseCase,
        private DeleteClientAddress $deleteClientAddressUseCase
    ) {}

    public function index(Request $request)
    {
        try {
            $companyId = $request->route('companyId') ?? 0;
            $input = new IdRequestDTO($companyId);
            $output = $this->listClientAddressUseCase->execute($input);
            return $this->outputSuccessArrayToJson($output, 200);
        } catch (Exception $e) {
            return $this->outputErrorArrayToJson($e->getMessage(), $e->getCode());
        }
    }

    public function store(Request $request)
    {

        $clientId = $request->clientId ?? 0;
        $country = $request->country ?? null;
        $zipCode = $request->zip_code ?? null;
        $state = $request->state ?? null;
        $city = $request->city ?? null;
        $neighborhood = $request->neighborhood ?? null;
        $street = $request->street ?? null;
        $number = $request->number ?? null;
        $complement = $request->complement ?? null;

        try {
            $input = new CreateClientAddressRequestDTO(
                $clientId,
                $country,
                $zipCode,
                $state,
                $city,
                $neighborhood,
                $street,
                $number,
                $complement
            );
            $output = $this->createClientAddressUseCase->execute($input);
            return $this->outputSuccessArrayToJson($output, 200);
        } catch (Exception $e) {
            return $this->outputErrorArrayToJson($e->getMessage(), $e->getCode());
        }
    }

    public function show(Request $request)
    {
        $id = $request->clientAddressId ?? 0;
        try {
            $input = new IdRequestDTO($id);
            $output = $this->showClientAddressUseCase->execute($input);
            return $this->outputSuccessArrayToJson($output, 200);
        } catch (Exception $e) {
            return $this->outputErrorArrayToJson($e->getMessage(), $e->getCode());
        }
    }

    public function update(Request $request)
    {
        $id = $request->clientAddressId ?? 0;
        $clientId = $request->clientId ?? 0;
        $country = $request->country ?? null;
        $zipCode = $request->zip_code ?? null;
        $state = $request->state ?? null;
        $city = $request->city ?? null;
        $neighborhood = $request->neighborhood ?? null;
        $street = $request->street ?? null;
        $number = $request->number ?? null;
        $complement = $request->complement ?? null;

        try {
            $input = new UpdateClientAddressRequestDTO(
                $id,
                $clientId,
                $country,
                $zipCode,
                $state,
                $city,
                $neighborhood,
                $street,
                $number,
                $complement
            );
            $output = $this->updateClientAddressUseCase->execute($input);
            return $this->outputSuccessArrayToJson($output, 200);
        } catch (Exception $e) {
            return $this->outputErrorArrayToJson($e->getMessage(), $e->getCode());
        }
    }

    public function delete(Request $request)
    {
        $id = $request->clientAddressId ?? 0;
        try {
            $input = new IdRequestDTO($id);
            $output = $this->deleteClientAddressUseCase->execute($input);
            return $this->outputSuccessArrayToJson($output, 200);
        } catch (Exception $e) {
            return $this->outputErrorArrayToJson($e->getMessage(), $e->getCode());
        }
    }
}
