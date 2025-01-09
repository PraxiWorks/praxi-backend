<?php

namespace App\Models\Scheduling;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventProcedure extends Model
{
    use HasFactory;
    protected $table = 'event_procedures';
    protected $primaryKey = 'id';

    protected $fillable = ['company_id', 'name', 'status'];

    public static function new(int $companyId, string $name, bool $status): EventProcedure
    {
        return new self(
            [
                'company_id' => $companyId,
                'name' => $name,
                'status' => $status,
            ]
        );
    }
}
