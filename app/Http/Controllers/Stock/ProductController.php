<?php

namespace App\Http\Controllers\Stock;

use App\Application\DTO\IdRequestDTO;
use App\Application\Stock\Product\CreateProduct;
use App\Application\Stock\Product\DeleteProduct;
use App\Application\Stock\Product\DTO\CreateProductRequestDTO;
use App\Application\Stock\Product\DTO\UpdateProductRequestDTO;
use App\Application\Stock\Product\ListProduct;
use App\Application\Stock\Product\ShowProduct;
use App\Application\Stock\Product\UpdateProduct;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function __construct(
        private CreateProduct $createProductUseCase,
        private ShowProduct $showProductUseCase,
        private ListProduct $listProductUseCase,
        private UpdateProduct $updateProductUseCase,
        private DeleteProduct $deleteProductUseCase
    ) {}

    public function index(Request $request)
    {
        $companyId = $request->route('companyId');

        try {
            $input = new IdRequestDTO($companyId);
            $output = $this->listProductUseCase->execute($input);
            return $this->outputSuccessArrayToJson($output, 200);
        } catch (Exception $e) {
            return $this->outputErrorArrayToJson($e->getMessage(), $e->getCode());
        }
    }

    public function store(Request $request)
    {
        $companyId = $request->route('companyId');
        $name = $request->name ?? '';
        $categoryId = $request->category_id ?? null;
        $skuCode = $request->sku_code ?? '';
        $price = $request->price ?? null;
        $imageBase64 = $request->image_base_64 ?? null;
        $currentStock = $request->current_stock ?? null;
        $minimumStockLevel = $request->minimum_stock_level ?? null;
        $maximumStockLevel = $request->maximum_stock_level ?? null;
        $status = $request->status ?? false;

        try {
            $input = new CreateProductRequestDTO(
                $companyId,
                $name,
                $categoryId,
                $skuCode,
                $price,
                $imageBase64,
                $currentStock,
                $minimumStockLevel,
                $maximumStockLevel,
                $status
            );
            $output = $this->createProductUseCase->execute($input);
            return $this->outputSuccessArrayToJson($output, 200);
        } catch (Exception $e) {
            dd($e);
            return $this->outputErrorArrayToJson($e->getMessage(), $e->getCode());
        }
    }

    public function show(Request $request)
    {
        $id = $request->route('productId') ?? 0;
        try {
            $input = new IdRequestDTO($id);
            $output = $this->showProductUseCase->execute($input);
            return $this->outputSuccessArrayToJson($output, 200);
        } catch (Exception $e) {
            return $this->outputErrorArrayToJson($e->getMessage(), $e->getCode());
        }
    }


    public function update(Request $request)
    {
        $companyId = $request->route('companyId');
        $productId = $request->route('productId') ?? 0;
        $name = $request->name ?? '';
        $categoryId = $request->category_id ?? null;
        $skuCode = $request->sku_code ?? '';
        $price = $request->price ?? null;
        $imageBase64 = $request->image_base_64 ?? null;
        $currentStock = $request->current_stock ?? null;
        $minimumStockLevel = $request->minimum_stock_level ?? null;
        $maximumStockLevel = $request->maximum_stock_level ?? null;
        $status = $request->status ?? false;

        try {
            $input = new UpdateProductRequestDTO(
                $companyId,
                $productId,
                $name,
                $categoryId,
                $skuCode,
                $price,
                $imageBase64,
                $currentStock,
                $minimumStockLevel,
                $maximumStockLevel,
                $status
            );
            $output = $this->updateProductUseCase->execute($input);
            return $this->outputSuccessArrayToJson($output, 200);
        } catch (Exception $e) {
            return $this->outputErrorArrayToJson($e->getMessage(), $e->getCode());
        }
    }

    public function delete(Request $request)
    {
        $id = $request->route('productId') ?? 0;
        try {
            $input = new IdRequestDTO($id);
            $output = $this->deleteProductUseCase->execute($input);
            return $this->outputSuccessArrayToJson($output, 200);
        } catch (Exception $e) {
            return $this->outputErrorArrayToJson($e->getMessage(), $e->getCode());
        }
    }
}
