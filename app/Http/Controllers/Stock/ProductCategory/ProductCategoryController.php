<?php

namespace App\Http\Controllers\Stock\ProductCategory;

use App\Application\DTO\IdRequestDTO;
use App\Application\Stock\ProductCategory\CreateProductCategory;
use App\Application\Stock\ProductCategory\DeleteProductCategory;
use App\Application\Stock\ProductCategory\DTO\CreateProductCategoryRequestDTO;
use App\Application\Stock\ProductCategory\DTO\ListProductCategoryRequestDTO;
use App\Application\Stock\ProductCategory\DTO\UpdateProductCategoryRequestDTO;
use App\Application\Stock\ProductCategory\ListProductCategory;
use App\Application\Stock\ProductCategory\ShowProductCategory;
use App\Application\Stock\ProductCategory\UpdateProductCategory;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;

class ProductCategoryController extends Controller
{

    public function __construct(
        private CreateProductCategory $createProductCategoryUseCase,
        private ShowProductCategory $showProductCategoryUseCase,
        private ListProductCategory $listProductCategoryUseCase,
        private UpdateProductCategory $updateProductCategoryUseCase,
        private DeleteProductCategory $deleteProductCategoryUseCase
    ) {}

    public function index(Request $request)
    {
        $companyId = $request->route('companyId');
        $status = $request->status ?? '';

        try {
            $input = new ListProductCategoryRequestDTO(
                $companyId,
                $status
            );
            $output = $this->listProductCategoryUseCase->execute($input);
            return $this->outputSuccessArrayToJson($output, 200);
        } catch (Exception $e) {
            return $this->outputErrorArrayToJson($e->getMessage(), $e->getCode());
        }
    }

    public function store(Request $request)
    {
        $companyId = $request->route('companyId');
        $name = $request->name ?? '';
        $status = $request->status ?? false;

        try {
            $input = new CreateProductCategoryRequestDTO(
                $companyId,
                $name,
                $status
            );
            $output = $this->createProductCategoryUseCase->execute($input);
            return $this->outputSuccessArrayToJson($output, 200);
        } catch (Exception $e) {
            return $this->outputErrorArrayToJson($e->getMessage(), $e->getCode());
        }
    }

    public function show(Request $request)
    {
        $id = $request->route('productCategoryId') ?? 0;
        try {
            $input = new IdRequestDTO($id);
            $output = $this->showProductCategoryUseCase->execute($input);
            return $this->outputSuccessArrayToJson($output, 200);
        } catch (Exception $e) {
            return $this->outputErrorArrayToJson($e->getMessage(), $e->getCode());
        }
    }


    public function update(Request $request)
    {
        $companyId = $request->route('companyId');
        $productCategoryId = $request->route('productCategoryId') ?? 0;
        $name = $request->name ?? '';
        $status = $request->status ?? false;

        try {
            $input = new UpdateProductCategoryRequestDTO(
                $companyId,
                $productCategoryId,
                $name,
                $status
            );
            $output = $this->updateProductCategoryUseCase->execute($input);
            return $this->outputSuccessArrayToJson($output, 200);
        } catch (Exception $e) {
            return $this->outputErrorArrayToJson($e->getMessage(), $e->getCode());
        }
    }

    public function delete(Request $request)
    {
        $id = $request->route('productCategoryId') ?? 0;
        try {
            $input = new IdRequestDTO($id);
            $output = $this->deleteProductCategoryUseCase->execute($input);
            return $this->outputSuccessArrayToJson($output, 200);
        } catch (Exception $e) {
            return $this->outputErrorArrayToJson($e->getMessage(), $e->getCode());
        }
    }
}
