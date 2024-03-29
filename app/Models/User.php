<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [

        'user_name',
        'image',
        'country',
        'city',
        'phone_number',
        'role',
        'is_active',
        'description',
        'email',
        'gender',
        'location',
        'address',
        'password',
        'last_seen',
        'email_verified_at',
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
    // public function cd_countries()
    // {
    //     return $this->belongsTo(CdCountry::class, 'country_id');
    // }
    // public function cd_cities()
    // {
    //     return $this->belongsTo(CdCity::class, 'city_id');
    // }
    public function cd_roles()
    {
        return $this->belongsTo(CdRole::class, 'Cd_role_id');
    }

    public function services()
    {
        return $this->hasMany(CdAppointment::class, 'service_id');
    }

    public function appointments()
    {
        return $this->hasMany(CdAppointment::class, 'customer_id');
    }
    public function socialmedia()
    {
        return $this->hasOne(CdSocialMedia::class);
    }

}
