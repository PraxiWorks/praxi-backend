<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EventRecurrenceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $eventRecurrences = [
            ['name' => 'Não se repete', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Todos os dias', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Toda Semana', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Todo Mês', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'A cada dois meses', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'A cada três meses', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'A cada seis meses', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Todo ano', 'created_at' => now(), 'updated_at' => now()],
        ];

        foreach ($eventRecurrences as $recurrence) {
            DB::table('event_recurrences')->updateOrInsert(
                ['name' => $recurrence['name']], // Evita duplicação
                $recurrence
            );
        }
    }
}
