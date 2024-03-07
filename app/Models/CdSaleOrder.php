<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CdSaleOrder extends Model
{
    use HasFactory;
    protected $fillable = [
        'cd_staff_id',
        'is_active',
        'description',
        'order_status_details',
        'order_status',
        'order_delay',
        'created_by',
        'updated_by',
    ];
    public function cd_staff()
    {
        return $this->belongsTo(CdStaff::class, 'cd_staff_id');
    }
}
