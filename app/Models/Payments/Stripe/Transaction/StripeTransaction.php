<?php

namespace App\Models\Payments\Stripe\Transaction;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StripeTransaction extends Model
{
    use HasFactory;
    protected $table = 'stripe_transactions';
    protected $primaryKey = 'id';

    protected $fillable = [
        'company_id',
        'user_id',
        'subscription_id',
        'transaction_id',
        'status',
        'amount'
    ];

    public static function new(
        int $companyId,
        int $userId,
        string $subscriptionId,
        string $transactionId,
        string $status,
        float $amount
    ): StripeTransaction {
        return new self(
            [
                'company_id' => $companyId,
                'user_id' => $userId,
                'subscription_id' => $subscriptionId,
                'transaction_id' => $transactionId,
                'status' => $status,
                'amount' => $amount
            ]
        );
    }
}
