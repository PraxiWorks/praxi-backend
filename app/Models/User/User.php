<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;
    protected $table = 'users';
    protected $primaryKey = 'id';

    protected $fillable = [
        'company_id',
        'name',
        'email',
        'phone_number',
        'user_type_id',
        'date_of_birth',
        'cpf_number',
        'rg_number',
        'gender',
        'send_notification_email',
        'send_notification_sms',
        'send_notification_whatsapp',
        'path_image',
        'password',
        'status'
    ];

    public static function new(
        int $companyId,
        string $name,
        string $email,
        ?string $phoneNumber,
        int $userTypeId,
        ?string $dateOfBirth,
        ?string $cpfNumber,
        ?string $rgNumber,
        ?string $gender,
        ?bool $sendNotificationEmail,
        ?bool $sendNotificationSms,
        ?bool $sendNotificationWhatsapp,
        string $pathImage,
        ?string $password,
        bool $status
    ): User {
        return new self(
            [
                'company_id' => $companyId,
                'name' => $name,
                'email' => $email,
                'phone_number' => $phoneNumber,
                'user_type_id' => $userTypeId,
                'date_of_birth' => $dateOfBirth,
                'cpf_number' => $cpfNumber,
                'rg_number' => $rgNumber,
                'gender' => $gender,
                'send_notification_email' => $sendNotificationEmail,
                'send_notification_sms' => $sendNotificationSms,
                'send_notification_whatsapp' => $sendNotificationWhatsapp,
                'path_image' => $pathImage,
                'password' => $password,
                'status' => $status
            ]
        );
    }
}
