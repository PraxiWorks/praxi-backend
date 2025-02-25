<?php

namespace App\Http\Controllers\Stock\Supplier;

use App\Application\DTO\IdRequestDTO;
use App\Application\Stock\Supplier\CreateSupplier;
use App\Application\Stock\Supplier\DeleteSupplier;
use App\Application\Stock\Supplier\DTO\CreateSupplierRequestDTO;
use App\Application\Stock\Supplier\DTO\ListSupplierRequestDTO;
use App\Application\Stock\Supplier\DTO\UpdateSupplierRequestDTO;
use App\Application\Stock\Supplier\ListSupplier;
use App\Application\Stock\Supplier\ShowSupplier;
use App\Application\Stock\Supplier\UpdateSupplier;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;

class SupplierController extends Controller
{

    public function __construct(
        private CreateSupplier $createSupplierUseCase,
        private ShowSupplier $showSupplierUseCase,
        private ListSupplier $listSupplierUseCase,
        private UpdateSupplier $updateSupplierUseCase,
        private DeleteSupplier $deleteSupplierUseCase
    ) {}

    public function index(Request $request)
    {
        $companyId = $request->route('companyId');
        $status = $request->status ?? '';

        try {
            $input = new ListSupplierRequestDTO(
                $companyId,
                $status
            );
            $output = $this->listSupplierUseCase->execute($input);
            return $this->outputSuccessArrayToJson($output, 200);
        } catch (Exception $e) {
            return $this->outputErrorArrayToJson($e->getMessage(), $e->getCode());
        }
    }

    public function store(Request $request)
    {
        $companyId = $request->route('companyId');
        $name = $request->name ?? '';
        $phoneNumber = $request->phone_number ?? '';
        $cnpjNumber = $request->cnpj_number ?? '';
        $imageBase64 = $request->image_base_64 ?? '';
        $status = $request->status ?? false;

        try {
            $input = new CreateSupplierRequestDTO(
                $companyId,
                $name,
                $phoneNumber,
                $cnpjNumber,
                $imageBase64,
                $status
            );
            $output = $this->createSupplierUseCase->execute($input);
            return $this->outputSuccessArrayToJson($output, 200);
        } catch (Exception $e) {
            return $this->outputErrorArrayToJson($e->getMessage(), $e->getCode());
        }
    }

    public function show(Request $request)
    {
        $id = $request->route('supplierId') ?? 0;
        try {
            $input = new IdRequestDTO($id);
            $output = $this->showSupplierUseCase->execute($input);
            return $this->outputSuccessArrayToJson($output, 200);
        } catch (Exception $e) {
            return $this->outputErrorArrayToJson($e->getMessage(), $e->getCode());
        }
    }


    public function update(Request $request)
    {
        $companyId = $request->route('companyId');
        $id = $request->route('supplierId') ?? 0;
        $name = $request->name ?? '';
        $phoneNumber = $request->phone_number ?? '';
        $cnpjNumber = $request->cnpj_number ?? '';
        $imageBase64 = $request->image_base64 ?? '';
        $status = $request->status ?? false;

        try {
            $input = new UpdateSupplierRequestDTO(
                $companyId,
                $id,
                $name,
                $phoneNumber,
                $cnpjNumber,
                $imageBase64,
                $status
            );
            $output = $this->updateSupplierUseCase->execute($input);
            return $this->outputSuccessArrayToJson($output, 200);
        } catch (Exception $e) {
            return $this->outputErrorArrayToJson($e->getMessage(), $e->getCode());
        }
    }

    public function delete(Request $request)
    {
        $id = $request->route('supplierId') ?? 0;
        try {
            $input = new IdRequestDTO($id);
            $output = $this->deleteSupplierUseCase->execute($input);
            return $this->outputSuccessArrayToJson($output, 200);
        } catch (Exception $e) {
            return $this->outputErrorArrayToJson($e->getMessage(), $e->getCode());
        }
    }
}
