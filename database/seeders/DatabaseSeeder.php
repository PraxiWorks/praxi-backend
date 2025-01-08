<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            ModulesSeeder::class,
            Permissions\SystemPermissionsSeeder::class,
            Permissions\StockPermissionsSeeder::class,
            Permissions\SchedulingPermissionsSeeder::class,
            FreePlanSeeder::class,
            PraxiSeeder::class,
            EventColorSeeder::class,
            EventProcedureSeeder::class,
            EventRecurrenceSeeder::class,
            EventStatusSeeder::class,
            EventTypeSeeder::class,
        ]);
    }
}
