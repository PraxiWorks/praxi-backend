<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EventTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $eventTypes = [
            ['name' => 'Agendamento', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Bloqueio de Tempo', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Lembrete', 'created_at' => now(), 'updated_at' => now()]
        ];

        foreach ($eventTypes as $types) {
            DB::table('event_types')->updateOrInsert(
                ['name' => $types['name']], // Evita duplicação
                $types
            );
        }
    }
}
