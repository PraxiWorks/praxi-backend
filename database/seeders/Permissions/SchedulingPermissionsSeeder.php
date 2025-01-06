<?php

namespace Database\Seeders\Permissions;

class SchedulingPermissionsSeeder extends BasePermissionsSeeder
{
    protected function getModuleName(): string
    {
        return 'Scheduling';
    }

    protected function getPermissions(): array
    {
        return [
            'scheduling.scheduleSettings.list',
            'scheduling.scheduleSettings.store',
            'scheduling.scheduleSettings.show',
            'scheduling.scheduleSettings.update',
            'scheduling.scheduleSettings.delete',

            'scheduling.event.list',
            'scheduling.event.store',
            'scheduling.event.show',
            'scheduling.event.update',
            'scheduling.event.delete',
        ];
    }
}
