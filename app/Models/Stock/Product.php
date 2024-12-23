<?php

namespace App\Models\Stock;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = 'products';
    protected $primaryKey = 'id';

    protected $fillable = [
        'company_id',
        'name',
        'category_id',
        'sku_code',
        'price',
        'path_image',
        'status',
        'current_stock',
        'minimum_stock_level',
        'maximum_stock_level'
    ];

    public static function new(
        int $companyId,
        string $name,
        ?string $categoryId,
        string $skuCode,
        ?float $price,
        ?string $imageBase64,
        string $status,
        ?int $currentStock,
        ?int $minimumStockLevel,
        ?int $maximumStockLevel
    ): Product {
        return new self(
            [
                'company_id' => $companyId,
                'name' => $name,
                'category_id' => $categoryId,
                'sku_code' => $skuCode,
                'price' => $price,
                'path_image' => $imageBase64,
                'status' => $status,
                'current_stock' => $currentStock,
                'minimum_stock_level' => $minimumStockLevel,
                'maximum_stock_level' => $maximumStockLevel
            ]
        );
    }
}
