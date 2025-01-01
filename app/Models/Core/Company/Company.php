<?php

namespace App\Models\Core\Company;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
    protected $table = 'companies';
    protected $primaryKey = 'id';

    protected $fillable = ['name', 'start_trial', 'end_trial'];

    public static function new(string $name, ?string $startTrial, ?string $endTrial): Company
    {
        return new self(
            [
                'name' => $name,
                'start_trial' => $startTrial,
                'end_trial' => $endTrial
            ]
        );
    }
}
