<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CdUserProfile extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_name',
        'phone_number',
        'Email',
        'Rating',
        'Image',
        'created_by',
        'updated_by',
    ];
}
