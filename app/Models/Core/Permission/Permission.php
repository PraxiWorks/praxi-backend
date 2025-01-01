<?php

namespace App\Models\Core\Permission;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;
    protected $table = 'permissions';
    protected $primaryKey = 'id';

    protected $fillable = ['name', 'status'];

    public static function new(int $name, bool $status): Permission
    {
        return new self(
            [
                'name' => $name,
                'status' => $status
            ]
        );
    }
}
