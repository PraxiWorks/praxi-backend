<?php

namespace App\Models\Payments\Stripe\Refund;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StripeRefund extends Model
{
    use HasFactory;
    protected $table = 'stripe_refunds';
    protected $primaryKey = 'id';

    protected $fillable = [
        'company_id',
        'user_id',
        'transaction_id',
        'refund_id',
        'amount',
        'status'
    ];

    public static function new(
        int $companyId,
        int $userId,
        int $transactionId,
        string $refundId,
        string $amount,
        string $status
    ): StripeRefund {
        return new self(
            [
                'company_id' => $companyId,
                'user_id' => $userId,
                'transaction_id' => $transactionId,
                'refund_id' => $refundId,
                'amount' => $amount,
                'status' => $status
            ]
        );
    }
}
