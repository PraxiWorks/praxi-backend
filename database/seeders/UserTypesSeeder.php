<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('user_types')->insert([
            [
                'id' => 1,
                'name' => 'Grand Master',
                'created_at' => now(),
            ],
            [
                'id' => 2,
                'name' => 'Administrador',
                'created_at' => now(),
            ]
        ]);
    }
}
