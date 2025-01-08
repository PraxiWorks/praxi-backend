<?php

namespace App\Models\Scheduling;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventRecurrence extends Model
{
    use HasFactory;
    protected $table = 'event_recurrences';
    protected $primaryKey = 'id';

    protected $fillable = ['name'];

    public static function new(string $name): EventRecurrence
    {
        return new self(
            [
                'name' => $name
            ]
        );
    }
}
