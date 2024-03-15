<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CdBranch extends Model
{
    use HasFactory;
    protected $fillable=[ 
    'name',
    'cd_company_id',
    'location',
    'address',
    'is_active',
    'description',
    'created_by',
    'updated_by',

    ];
   
    public function td_orders()
    {
        return $this->hasMany(TdOrder::class, 'cd_branch_id');
    }
    public function td_order_details()
    {
        return $this->hasMany(TdOrderDetail::class, 'cd_branch_id');
    }
    public function td_purchases()
    {
        return $this->hasMany(TdPurchase::class, 'cd_branch_id');
    }
    public function td_purchase_details()
    {
        return $this->hasMany(TdPurchaseDetail::class, 'cd_branch_id');
    }
    public function td_receipts()
    {
        return $this->hasMany(TdReceipt::class, 'cd_branch_id');
    }
    public function cd_companies()
    {
        return $this->belongsTo(CdCompany::class, 'cd_company_id');
    }

}
