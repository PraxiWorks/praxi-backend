<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FreePlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $plan = [
            'name' => 'Plano Gratuito',
            'description' => 'Plano gratuito com todos os modulos disponíveis',
            'price' => 0,
            'duration_days' => 15,
            'status' => 1,
            'created_at' => now()
        ];

        DB::table('plans')->updateOrInsert(
            ['name' => $plan['name']],
            $plan
        );

        $planId = DB::table('plans')->where('name', $plan['name'])->value('id');
        $modules = DB::table('modules')->get();

        foreach ($modules as $module) {
            DB::table('plan_modules')->updateOrInsert(
                [
                    'plan_id' => $planId,
                    'module_id' => $module->id
                ],
                [
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            );
        }
    }
}
