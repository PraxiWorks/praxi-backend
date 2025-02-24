<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ModulesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $modules = [
            ['name' => 'System', 'status' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Scheduling', 'status' => 1, 'created_at' => now(), 'updated_at' => now()],
            // ['name' => 'Stock', 'status' => 1, 'created_at' => now(), 'updated_at' => now()],
        ];

        foreach ($modules as $module) {
            DB::table('modules')->updateOrInsert(
                ['name' => $module['name']], // Evita duplicação
                $module
            );
        }
    }
}
