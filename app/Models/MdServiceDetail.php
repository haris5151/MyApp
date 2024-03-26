<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MdServiceDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'md_service_id',
        'icon',
        'service_name',
        'description',
        'created_by',
        'updated_by',
    ];
    
    
    public function mdService()
    {
        return $this->belongsTo(MdService::class);
    }
}
