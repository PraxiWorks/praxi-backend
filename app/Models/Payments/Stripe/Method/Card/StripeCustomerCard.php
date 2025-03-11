<?php

namespace App\Models\Payments\Stripe\Method\Card;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StripeCustomerCard extends Model
{
    use HasFactory;
    protected $table = 'stripe_customer_cards';
    protected $primaryKey = 'id';

    protected $fillable = [
        'customer_id',
        'card_id',
        'last4',
        'exp_month',
        'exp_year',
    ];

    public static function new(string $customerId, string $cardId, string $last4, int $expMonth, int $expYear): StripeCustomerCard
    {
        return new self(
            [
                'customer_id' => $customerId,
                'card_id' => $cardId,
                'last4' => $last4,
                'exp_month' => $expMonth,
                'exp_year' => $expYear,
            ]
        );
    }
}
