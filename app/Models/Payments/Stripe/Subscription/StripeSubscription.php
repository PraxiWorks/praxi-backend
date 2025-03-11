<?php

namespace App\Models\Payments\Stripe\Subscription;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StripeSubscription extends Model
{
    use HasFactory;
    protected $table = 'stripe_subscriptions';
    protected $primaryKey = 'id';

    protected $fillable = [
        'company_id',
        'user_id',
        'subscription_id',
        'status',
        'start_date'
    ];

    public static function new(
        int $companyId,
        int $userId,
        string $subscriptionId,
        string $status,
        string $startDate
    ): StripeSubscription {
        return new self(
            [
                'company_id' => $companyId,
                'user_id' => $userId,
                'subscription_id' => $subscriptionId,
                'status' => $status,
                'start_date' => $startDate
            ]
        );
    }
}
