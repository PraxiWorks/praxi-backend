<?php

namespace Tests\Application\Settings\Permission\Mapper;

use PHPUnit\Framework\TestCase;
use App\Application\Settings\Permission\Mapper\ListPermissionMapper;
use App\Application\DTO\OutputArrayDTO;

class ListPermissionMapperTest extends TestCase
{
    public function testToOutputDto()
    {
        $mapper = new ListPermissionMapper();

        $rows = [
            ['id' => 1, 'display_name' => 'View Users', 'name' => 'users.view'],
            ['id' => 2, 'display_name' => 'Edit Users', 'name' => 'users.edit'],
            ['id' => 3, 'display_name' => 'View Roles', 'name' => 'roles.view'],
        ];

        $expectedOutput = new OutputArrayDTO([
            'users' => [
                ['id' => 1, 'display_name' => 'View Users', 'name' => 'users.view'],
                ['id' => 2, 'display_name' => 'Edit Users', 'name' => 'users.edit'],
            ],
            'roles' => [
                ['id' => 3, 'display_name' => 'View Roles', 'name' => 'roles.view'],
            ],
        ]);

        $output = $mapper->toOutputDto($rows);

        $this->assertEquals($expectedOutput, $output);
    }
}
