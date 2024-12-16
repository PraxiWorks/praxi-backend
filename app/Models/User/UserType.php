<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserType extends Model
{
    use HasFactory;
    protected $table = 'user_types';
    protected $primaryKey = 'id';

    protected $fillable = ['name'];

    public static function new(string $name): UserType
    {
        return new self(
            [
                'name' => $name
            ]
        );
    }
}
