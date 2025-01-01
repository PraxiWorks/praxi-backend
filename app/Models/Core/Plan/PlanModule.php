<?php

namespace App\Models\Core\Plan;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanModule extends Model
{
    use HasFactory;
    protected $table = 'plan_modules';
    protected $primaryKey = 'id';

    protected $fillable = ['plan_id', 'module_id'];

    public static function new(int $planId, int $moduleId): PlanModule
    {
        return new self(
            [
                'plan_id' => $planId,
                'module_id' => $moduleId
            ]
        );
    }
}
