<?php

namespace App\Models\Settings\GroupPermission;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupPermission extends Model
{
    use HasFactory;
    protected $table = 'group_permissions';
    protected $primaryKey = 'id';

    protected $fillable = ['group_id', 'permission_id'];

    public static function new(int $groupId, int $permissionId): GroupPermission
    {
        return new self(
            [
                'group_id' => $groupId,
                'permission_id' => $permissionId
            ]
        );
    }
}
