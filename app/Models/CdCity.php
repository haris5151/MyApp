<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CdCity extends Model
{
    use HasFactory;
    protected $fillable = [
        'state_id',
        'name',
        'is_active',
        'description',
        'created_by',
        'updated_by',
    ];
    public function users()
    {
        return $this->hasMany(User::class, 'city_id');
    }
    public function cd_states()
    {
        return $this->belongsTo(CdState::class, 'state_id');
    }

}
