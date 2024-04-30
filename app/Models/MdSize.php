<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MdSize extends Model
{
    use HasFactory;
    protected $fillable = [
        'chest_width',
        'size_name',
        'collar',
        'pent_length',
        'waist_width',
        'sleeve_length',
        'shoulder_width',
        'shirt_length',
        'gender',
        'is_active',
        'description',
        'created_by',
        'updated_by',
    ];
    public function md_size_details()
    {
        return $this->hasMany(MdSizeDetail::class, 'md_size_id');
    }
    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
