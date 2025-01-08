<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EventStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $eventStatus = [
            ['name' => 'Agendado', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Confirmado', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Reagendado', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Cancelado', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Não compareceu', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Aguardando', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Finalizado', 'created_at' => now(), 'updated_at' => now()],
        ];

        foreach ($eventStatus as $status) {
            DB::table('event_status')->updateOrInsert(
                ['name' => $status['name']], // Evita duplicação
                $status
            );
        }
    }
}
