<?php

namespace App\Models\Settings\Company;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyModule extends Model
{
    use HasFactory;
    protected $table = 'company_modules';
    protected $primaryKey = 'id';

    protected $fillable = ['company_id', 'module_id'];

    public static function new(int $companyId, int $moduleId): CompanyModule
    {
        return new self(
            [
                'company_id' => $companyId,
                'module_id' => $moduleId
            ]
        );
    }
}
