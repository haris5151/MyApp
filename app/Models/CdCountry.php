<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CdCountry extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'is_active',
        'description',
        'country_code',
        'created_by',
        'updated_by',
    ];
    public function cd_cities()
    {
        return $this->hasMany(CdCity::class, 'cd_country_id');
    }
    public function users()
    {
        return $this->hasMany(User::class, 'cd_country_id');
    }
}
