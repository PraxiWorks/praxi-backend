<?php

namespace App\Application\Settings\Permission\Mapper;

use App\Application\DTO\OutputArrayDTO;

class ListPermissionMapper
{
    public function __construct() {}

    public function toOutputDto(array $rows)
    {
        $permissionsByModule = [];

        foreach ($rows as $row) {
            $module = explode('.', $row['name'])[0];
            if (!isset($permissionsByModule[$module])) {
                $permissionsByModule[$module] = [];
            }

            $permissionsByModule[$module][] = [
                'id' => $row['id'],
                'display_name' => $row['display_name'],
                'name' => $row['name']
            ];
        }

        return new OutputArrayDTO($permissionsByModule);
    }
}
