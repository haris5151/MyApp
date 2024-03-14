<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CdRole extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'role_type',
        'is_active',
        'description',
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'cd_role_id');
    }
}
