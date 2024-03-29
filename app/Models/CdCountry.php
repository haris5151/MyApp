<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CdCountry extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'sortname',
        'is_active',
        'description',
        'created_by',
        'updated_by',
    ];
    public function cd_states()
    {
        return $this->hasMany(CdCity::class, 'country_id');
    }
    public function users()
    {
        return $this->hasMany(User::class, 'country_id');
    }
}
