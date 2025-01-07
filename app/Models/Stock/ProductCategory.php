<?php

namespace App\Models\Stock;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    use HasFactory;
    protected $table = 'product_categories';
    protected $primaryKey = 'id';

    protected $fillable = [
        'company_id',
        'name',
        'status'
    ];

    public static function new(
        int $companyId,
        string $name,
        string $status
    ): ProductCategory {
        return new self(
            [
                'company_id' => $companyId,
                'name' => $name,
                'status' => $status,
            ]
        );
    }
}
