<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MdSizeDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'md_size_id',
        'is_active',
        'description', 
        'created_by',
        'updated_by',
    ];
    public function md_sizes()
    {
        return $this->belongsTo(MdSize::class, 'md_size_id');
    }
    
}
