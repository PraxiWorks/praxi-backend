<?php

namespace App\Models\Core\Permission;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModulePermission extends Model
{
    use HasFactory;
    protected $table = 'module_permissions';
    protected $primaryKey = 'id';

    protected $fillable = ['module_id', 'permission_id'];

    public static function new(int $moduleId, int $permissionId): ModulePermission
    {
        return new self(
            [
                'module_id' => $moduleId,
                'permission_id' => $permissionId
            ]
        );
    }
}
