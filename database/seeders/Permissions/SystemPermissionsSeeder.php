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
            ['display_name' => 'Listar Usuários', 'name' => 'system.user.list'],
            ['display_name' => 'Criar Usuário', 'name' => 'system.user.store'],
            ['display_name' => 'Mostrar Usuário', 'name' => 'system.user.show'],
            ['display_name' => 'Atualizar Usuário', 'name' => 'system.user.update'],
            ['display_name' => 'Deletar Usuário', 'name' => 'system.user.delete'],

            ['display_name' => 'Listar Grupos', 'name' => 'system.group.list'],
            ['display_name' => 'Criar Grupo', 'name' => 'system.group.store'],
            ['display_name' => 'Mostrar Grupo', 'name' => 'system.group.show'],
            ['display_name' => 'Atualizar Grupo', 'name' => 'system.group.update'],
            ['display_name' => 'Deletar Grupo', 'name' => 'system.group.delete'],

            ['display_name' => 'Listar Planos', 'name' => 'system.plan.list'],
            ['display_name' => 'Criar Plano', 'name' => 'system.plan.store'],
            ['display_name' => 'Mostrar Plano', 'name' => 'system.plan.show'],
            ['display_name' => 'Atualizar Plano', 'name' => 'system.plan.update'],
            ['display_name' => 'Deletar Plano', 'name' => 'system.plan.delete']
        ];
    }
}
