<?php

namespace App\Models\Register\Group;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;
    protected $table = 'groups';
    protected $primaryKey = 'id';

    protected $fillable = ['company_id', 'name', 'status'];

    public static function new(int $companyId, string $name, bool $status): Group
    {
        return new self(
            [
                'company_id' => $companyId,
                'name' => $name,
                'status' => $status
            ]
        );
    }
}
