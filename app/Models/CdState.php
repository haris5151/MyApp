<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CdState extends Model
{
    use HasFactory;
    protected $fillable = [
        'country_id',
        'name',
        'is_active',
        'description',
        'created_by',
        'updated_by',
    ];
    public function cd_countries()
    {
        return $this->belongsTo(CdCountry::class, 'country_id');
    }
    public function cd_cities()
    {
        return $this->hasMany(CdCity::class, 'state_id');
    }
    public function users()
    {
        return $this->hasMany(User::class, 'state_id');
    }
}
