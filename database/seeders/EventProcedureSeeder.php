<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EventProcedureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $eventProcedures = [
            ['company_id' => '1', 'name' => 'Revisão Geral', 'created_at' => now(), 'updated_at' => now()],
        ];

        foreach ($eventProcedures as $procedure) {
            DB::table('event_procedures')->updateOrInsert(
                ['name' => $procedure['name']], // Evita duplicação
                $procedure
            );
        }
    }
}
