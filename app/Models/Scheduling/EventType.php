<?php

namespace App\Models\Scheduling;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventType extends Model
{
    use HasFactory;
    protected $table = 'event_types';
    protected $primaryKey = 'id';

    protected $fillable = ['name'];

    public static function new(string $name): EventType
    {
        return new self(
            [
                'name' => $name
            ]
        );
    }
}
