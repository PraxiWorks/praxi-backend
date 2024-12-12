<?php

namespace App\Models\Company;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
    protected $table = 'companies';
    protected $primaryKey = 'id';

    protected $fillable = ['name'];

    public static function new(string $name): Company
    {
        return new self(
            [
                'name' => $name
            ]
        );
    }
}
