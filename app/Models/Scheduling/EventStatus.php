<?php

namespace App\Models\Scheduling;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventStatus extends Model
{
    use HasFactory;
    protected $table = 'event_status';
    protected $primaryKey = 'id';

    protected $fillable = ['name'];

    public static function new(string $name): EventStatus
    {
        return new self(
            [
                'name' => $name
            ]
        );
    }
}
