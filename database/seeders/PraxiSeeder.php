<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PraxiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $company = [
            "name" => "Praxi",
            "start_trial" => null,
            "end_trial" => null,
        ];

        DB::table('companies')->updateOrInsert(
            ['name' => $company['name']],
            $company
        );

        $companyId = DB::table('companies')->where('name', $company['name'])->value('id');

        if (empty($companyId)) {
            throw new \Exception('Erro ao obter o ID da empresa Praxi.');
        }

        $user = [
            "company_id" => $companyId,
            "username" => "grandmaster",
            "name" => "Praxi",
            "email" => "praxi@gmail.com",
            "phone_number" => "51992974166",
            "send_notification_email" => true,
            "send_notification_sms" => true,
            "send_notification_whatsapp" => true,
            "path_image" => config('image.praxi.default_image'),
            "password" => Hash::make('teste123'),
            "is_professional" => false,
            "status" => true,
            "created_at" => now(),
            "updated_at" => now()
        ];

        DB::table('users')->updateOrInsert(
            ['username' => $user['username']],
            $user
        );

        $userId = DB::table('users')->where('username', $user['username'])->value('id');

        if (empty($userId)) {
            throw new \Exception('Erro ao obter o ID do usuário grandmaster.');
        }

        $scheduleSettings = [
            [
                "company_id" => $companyId,
                "day_of_week" => "seg",
                "start_time" => "09:00",
                "end_time" => "17:00",
                "is_working_day" => true,
                "created_at" => now(),
                "updated_at" => now()
            ],
            [
                "company_id" => $companyId,
                "day_of_week" => "ter",
                "start_time" => "09:00",
                "end_time" => "17:00",
                "is_working_day" => true,
                "created_at" => now(),
                "updated_at" => now()
            ],
            [
                "company_id" => $companyId,
                "day_of_week" => "qua",
                "start_time" => "09:00",
                "end_time" => "17:00",
                "is_working_day" => true,
                "created_at" => now(),
                "updated_at" => now()
            ],
            [
                "company_id" => $companyId,
                "day_of_week" => "qui",
                "start_time" => "09:00",
                "end_time" => "17:00",
                "is_working_day" => true,
                "created_at" => now(),
                "updated_at" => now()
            ],
            [
                "company_id" => $companyId,
                "day_of_week" => "sex",
                "start_time" => "09:00",
                "end_time" => "17:00",
                "is_working_day" => true,
                "created_at" => now(),
                "updated_at" => now()
            ]
        ];

        foreach ($scheduleSettings as $setting) {
            DB::table('schedule_settings')->updateOrInsert(
                [
                    'company_id' => $setting['company_id'],
                    'day_of_week' => $setting['day_of_week']
                ],
                $setting
            );
        }

        $permissions = DB::table('permissions')->get();

        foreach ($permissions as $permission) {
            DB::table('user_permissions')->updateOrInsert(
                [
                    'user_id' => $userId,
                    'permission_id' => $permission->id
                ],
                [
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            );
        }
    }
}
