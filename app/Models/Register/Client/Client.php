<?php

namespace App\Models\Register\Client;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Client extends Authenticatable
{
    use HasFactory;
    protected $table = 'clients';
    protected $primaryKey = 'id';

    protected $fillable = [
        'company_id',
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
        'has_access_to_the_system',
        'group_id',
        'status'
    ];

    public static function new(
        int $companyId,
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
        bool $hasAccessToTheSystem,
        ?int $groupId,
        bool $status
    ): Client {
        return new self(
            [
                'company_id' => $companyId,
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
                'has_access_to_the_system' => $hasAccessToTheSystem,
                'group_id' => $groupId,
                'status' => $status
            ]
        );
    }
}
