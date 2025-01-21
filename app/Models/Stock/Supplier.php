<?php

namespace App\Models\Stock;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;
    protected $table = 'suppliers';
    protected $primaryKey = 'id';

    protected $fillable = [
        'company_id',
        'name',
        'phone_number',
        'cnpj_number',
        'path_image',
        'status'
    ];

    public static function new(
        int $companyId,
        string $name,
        string $phoneNumber,
        string $cnpjNumber,
        string $pathImage,
        bool $status
    ): Supplier {
        return new self(
            [
                'company_id' => $companyId,
                'name' => $name,
                'phone_number' => $phoneNumber,
                'cnpj_number' => $cnpjNumber,
                'path_image' => $pathImage,
                'status' => $status
            ]
        );
    }
}
