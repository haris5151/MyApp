<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CdCity extends Model
{
    use HasFactory;
    protected $fillable = [
        'cd_country_id',
        'name',
        'is_active',
        'description',
        'created_by',
        'updated_by',
    ];
    public function users()
    {
        return $this->hasMany(User::class, 'cd_city_id');
    }
    public function cd_countries()
    {
        return $this->belongsTo(CdCountry::class, 'cd_country_id');
    }

}
