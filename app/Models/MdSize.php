<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MdSize extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'chest_width',
        'waist_width',
        'sleeve_length',
        'shoulder_width',
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
