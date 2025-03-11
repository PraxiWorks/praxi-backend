<?php

namespace App\Http\Controllers\Payments\Stripe\Subscription;

use App\Application\DTO\IdRequestDTO;
use App\Application\Payments\Stripe\Subscription\CreateSubscription;
use App\Application\Payments\Stripe\Subscription\DTO\SubscriptionRequestDTO;
use App\Application\Payments\Stripe\Subscription\ShowSubscription;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{

    public function __construct(
        private CreateSubscription $createSubscriptionUseCase,
        private ShowSubscription $showSubscriptionUseCase
    ) {}

    public function store(Request $request)
    {
        ///User Data
        $module = $request->module ?? 0;
        $companyId = $request->companyId ?? 0;
        $userId = $request->user_id ?? 0;
        $email = $request->email ?? '';
        $name = $request->name ?? '';

        //Card Data
        $cardToken = $request->card_token ?? '';
        $priceId = $request->price_id ?? 0;

        try {
            $input = new SubscriptionRequestDTO(
                $module,
                $companyId,
                $userId,
                $email,
                $name,
                $cardToken,
                $priceId,
            );
            $output = $this->createSubscriptionUseCase->execute($input);
            return $this->outputSuccessArrayToJson($output, 200);
        } catch (Exception $e) {
            $statusCode = $e->getCode() > 0 ? $e->getCode() : 500;
            return $this->outputErrorArrayToJson($e->getMessage(), $statusCode);
        }
    }

    public function show(Request $request)
    {
        $subscriptionId = $request->route('subscriptionId') ?? 0;

        try {
            $input = new IdRequestDTO($subscriptionId);
            $output = $this->showSubscriptionUseCase->execute($input);
            return $this->outputSuccessArrayToJson($output, 200);
        } catch (Exception $e) {
            $statusCode = $e->getCode() > 0 ? $e->getCode() : 500;
            return $this->outputErrorArrayToJson($e->getMessage(), $statusCode);
        }
    }
}
