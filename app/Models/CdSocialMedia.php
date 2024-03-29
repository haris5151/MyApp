<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CdSocialMedia extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'facebook',
        'google',
        'twitter',
        'instagram',
        'linkedin',
        'github',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
