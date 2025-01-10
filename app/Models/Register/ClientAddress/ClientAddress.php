<?php

namespace App\Models\Register\ClientAddress;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class ClientAddress extends Authenticatable
{
    use HasFactory;
    protected $table = 'client_addresses';
    protected $primaryKey = 'id';

    protected $fillable = [
        'client_id',
        'country',
        'zip_code',
        'state',
        'city',
        'neighborhood',
        'street',
        'number',
        'complement'
    ];

    public static function new(
        int $clientId,
        string $country,
        ?string $zipCode,
        string $state,
        string $city,
        ?string $neighborhood,
        ?string $street,
        ?int $number,
        ?string $complement
    ): ClientAddress {
        return new self(
            [
                'client_id' => $clientId,
                'country' => $country,
                'zip_code' => $zipCode,
                'state' => $state,
                'city' => $city,
                'neighborhood' => $neighborhood,
                'street' => $street,
                'number' => $number,
                'complement' => $complement
            ]
        );
    }
}
