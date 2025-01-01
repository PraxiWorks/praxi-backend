<?php

namespace App\Models\Register\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPermission extends Model
{
    use HasFactory;
    protected $table = 'user_permissions';
    protected $primaryKey = 'id';

    protected $fillable = ['user_id', 'permission_id'];

    public static function new(int $user_id, int $permission_id): UserPermission
    {
        return new self(
            [
                'user_id' => $user_id,
                'permission_id' => $permission_id
            ]
        );
    }
}
