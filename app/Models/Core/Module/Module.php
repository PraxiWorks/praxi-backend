<?php

namespace App\Models\Core\Module;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use HasFactory;
    protected $table = 'modules';
    protected $primaryKey = 'id';

    protected $fillable = ['name', 'status'];

    public static function new(string $name, bool $status): Module
    {
        return new self(
            [
                'name' => $name,
                'status' => $status
            ]
        );
    }
}
