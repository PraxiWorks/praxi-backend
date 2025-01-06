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

            'system.plan.list',
            'system.plan.store',
            'system.plan.show',
            'system.plan.update',
            'system.plan.delete',

            'system.client.list',
            'system.client.store',
            'system.client.show',
            'system.client.update',
            'system.client.delete',
        ];
    }
}
