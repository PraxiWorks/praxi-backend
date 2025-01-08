<?php

namespace App\Models\Scheduling;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventColor extends Model
{
    use HasFactory;
    protected $table = 'event_colors';
    protected $primaryKey = 'id';

    protected $fillable = ['name', 'hash'];

    public static function new(string $name, string $hash): EventColor
    {
        return new self(
            [
                'name' => $name,
                'hash' => $hash
            ]
        );
    }
}
