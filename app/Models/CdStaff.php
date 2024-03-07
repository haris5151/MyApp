<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CdStaff extends Model
{
    use HasFactory;
    protected $fillable = [
        'td_order_id', 
        'td_order_detail_id',
        'is_active',
        'name',
        'phone_number',
        'description',  
        'created_by',
        'updated_by',
    ];
    public function cd_sale_orders()
    {
        return $this->hasMany(CdSaleOrder::class, 'cd_staff_id');
    }
    public function td_orders()
    {
        return $this->belongsTo(TdOrder::class, 'td_order_id');
    }
    public function td_order_details()
    {
        return $this->belongsTo(TdOrderDetail::class, 'td_order_detail_id');
    }
}
