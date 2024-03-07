<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MdExpense extends Model
{
    use HasFactory;
    protected $fillable = [
        'td_purchase_id',
        'td_purchase_detail_id',
        'is_active',
        'price',
        'description',
        'created_by',
        'updated_by',
    ];
    public function td_purchases()
    {
        return $this->belongsTo(TdPurchase::class, 'td_purchase_id');
    }
    public function td_purchase_details()
    {
        return $this->belongsTo(TdPurchaseDetail::class, 'td_purchase_detail_id');
    }
}
