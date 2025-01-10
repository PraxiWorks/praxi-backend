<?php

namespace App\Models\Core\Company;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyPlan extends Model
{
    use HasFactory;
    protected $table = 'company_plans';
    protected $primaryKey = 'id';

    protected $fillable = ['company_id', 'plan_id'];

    public static function new(int $companyId, int $planId): CompanyPlan
    {
        return new self(
            [
                'company_id' => $companyId,
                'plan_id' => $planId
            ]
        );
    }
}
