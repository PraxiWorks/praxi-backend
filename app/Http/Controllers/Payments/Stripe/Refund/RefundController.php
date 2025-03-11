<?php

namespace App\Http\Controllers\Payments\Stripe\Refund;

use App\Application\Payments\Stripe\Refund\DTO\ProcessRefundRequestDTO;
use App\Application\Payments\Stripe\Refund\ProcessRefund;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;

class RefundController extends Controller
{
    public function __construct(private ProcessRefund $processRefundUseCase) {}

    public function store(Request $request)
    {
        $companyId = $request->route('companyId');
        $userId = $request->route('id');

        try {
            $input = new ProcessRefundRequestDTO($companyId, $userId);
            $output = $this->processRefundUseCase->execute($input);
            return $this->outputSuccessArrayToJson($output, 200);
        } catch (Exception $e) {
            $statusCode = $e->getCode() > 0 ? $e->getCode() : 500;
            return $this->outputErrorArrayToJson($e->getMessage(), $statusCode);
        }
    }
}
