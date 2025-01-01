<?php

namespace Database\Seeders\Permissions;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

abstract class BasePermissionsSeeder extends Seeder
{
    /**
     * Nome do módulo.
     */
    abstract protected function getModuleName(): string;

    /**
     * Permissões do módulo.
     */
    abstract protected function getPermissions(): array;

    /**
     * Executa o Seeder.
     */
    public function run(): void
    {
        DB::transaction(function () {
            $permissions = $this->getPermissions();

            // Inserir permissões evitando duplicação
            foreach ($permissions as $permission) {
                DB::table('permissions')->updateOrInsert(
                    ['name' => $permission],
                    ['created_at' => now(), 'updated_at' => now()]
                );
            }

            // Buscar os IDs das permissões inseridas
            $permissionIds = DB::table('permissions')
                ->whereIn('name', $permissions)
                ->pluck('id')
                ->toArray();

            // Buscar o módulo pelo nome
            $module = DB::table('modules')->where('name', $this->getModuleName())->first();

            if (!$module) {
                $this->command->error("Módulo '{$this->getModuleName()}' não encontrado!");
                return;
            }

            // Vincular permissões ao módulo
            foreach ($permissionIds as $permissionId) {
                DB::table('module_permissions')->updateOrInsert(
                    [
                        'module_id' => $module->id,
                        'permission_id' => $permissionId
                    ],
                    [
                        'created_at' => now(),
                        'updated_at' => now()
                    ]
                );
            }
        });
    }
}
