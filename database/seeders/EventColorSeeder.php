<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EventColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $eventColors = [
            ['name' => 'Lavanda Acinzentada', 'hash' => '#c2c4d6', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Pêssego Claro', 'hash' => '#fbcfa3', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Amarelo Dourado Claro', 'hash' => '#ffdb8a', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Verde Lima Claro', 'hash' => '#e1ff7a', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Verde Menta ', 'hash' => '#baff8a', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Verde Turquesa Claro', 'hash' => '#8affb3', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Azul Água', 'hash' => '#8ff2f4', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Azul Céu Claro', 'hash' => '#8fcaff', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Lilás Pastel', 'hash' => '#b0aaff', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Lilás Suave', 'hash' => '#d1a3ff', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Rosa Chiclete', 'hash' => '#ff9ffb', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Rosa Coral Claro', 'hash' => '#ff9fba', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Salmão Claro', 'hash' => '#ff9f9a', 'created_at' => now(), 'updated_at' => now()],
        ];

        foreach ($eventColors as $color) {
            DB::table('event_colors')->updateOrInsert(
                ['name' => $color['name']], // Evita duplicação
                $color
            );
        }
    }
}
