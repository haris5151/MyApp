<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
   
     protected $fillable = [
        'cd_country_id',
        'cd_city_id',
        'user_name',
        'phone_number',
        'is_active',
        'description',
        // 'login',
        'email',
        'gender',
        'location',
        'address',
        'password',
        // 'password_confirmation',
        'email_verified_at',
        'remember_token',
        'created_by',
        'updated_by',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    public function md_sizes()
    {
        return $this->hasMany(MdSize::class, 'user_id');
    }
    public function cd_countries()
    {
        return $this->belongsTo(CdCountry::class, 'cd_country_id');
    }
    public function cd_cities()
    {
        return $this->belongsTo(CdCity::class, 'cd_city_id');
    }
}
