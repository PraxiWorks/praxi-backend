<?php

namespace App\Models\Core\Plan;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;
    protected $table = 'plans';
    protected $primaryKey = 'id';

    protected $fillable = ['name', 'description', 'price', 'duration_days', 'status'];

    public static function new(string $name, string $description, float $price, int $durationDays, bool $status): Plan
    {
        return new self(
            [
                'name' => $name,
                'description' => $description,
                'price' => $price,
                'duration_days' => $durationDays,
                'status' => $status
            ]
        );
    }
}
