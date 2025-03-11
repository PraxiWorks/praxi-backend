<?php

namespace App\Models\Payments\Stripe\Customer;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StripeCustomer extends Model
{
    use HasFactory;
    protected $table = 'stripe_customers';
    protected $primaryKey = 'id';

    protected $fillable = [
        'company_id',
        'user_id',
        'customer_id',
        'email'
    ];

    public static function new(
        int $companyId,
        int $userId,
        string $customerId,
        string $customerEmail
    ): StripeCustomer {
        return new self(
            [
                'company_id' => $companyId,
                'user_id' => $userId,
                'customer_id' => $customerId,
                'email' => $customerEmail
            ]
        );
    }
}
