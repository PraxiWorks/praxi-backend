<?php

namespace Database\Seeders\Permissions;

class SystemPermissionsSeeder extends BasePermissionsSeeder
{
    protected function getModuleName(): string
    {
        return 'System';
    }

    protected function getPermissions(): array
    {
        return [
            'system.user.list',
            'system.user.store',
            'system.user.show',
            'system.user.update',
            'system.user.delete',
            
            'system.group.list',
            'system.group.store',
            'system.group.show',
            'system.group.update',
            'system.group.delete',
        ];
    }
}
