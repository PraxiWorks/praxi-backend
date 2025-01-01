<?php

namespace App\Models\Register\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;
    protected $table = 'users';
    protected $primaryKey = 'id';

    protected $fillable = [
        'company_id',
        'username',
        'name',
        'email',
        'phone_number',
        'date_of_birth',
        'cpf_number',
        'rg_number',
        'gender',
        'send_notification_email',
        'send_notification_sms',
        'send_notification_whatsapp',
        'path_image',
        'password',
        'is_professional',
        'group_id',
        'status'
    ];

    public static function new(
        int $companyId,
        string $username,
        string $name,
        string $email,
        ?string $phoneNumber,
        ?string $dateOfBirth,
        ?string $cpfNumber,
        ?string $rgNumber,
        ?string $gender,
        ?bool $sendNotificationEmail,
        ?bool $sendNotificationSms,
        ?bool $sendNotificationWhatsapp,
        string $pathImage,
        ?string $password,
        bool $isProfessional,
        ?int $groupId,
        bool $status
    ): User {
        return new self(
            [
                'company_id' => $companyId,
                'username' => $username,
                'name' => $name,
                'email' => $email,
                'phone_number' => $phoneNumber,
                'date_of_birth' => $dateOfBirth,
                'cpf_number' => $cpfNumber,
                'rg_number' => $rgNumber,
                'gender' => $gender,
                'send_notification_email' => $sendNotificationEmail,
                'send_notification_sms' => $sendNotificationSms,
                'send_notification_whatsapp' => $sendNotificationWhatsapp,
                'path_image' => $pathImage,
                'password' => $password,
                'is_professional' => $isProfessional,
                'group_id' => $groupId,
                'status' => $status
            ]
        );
    }
}
