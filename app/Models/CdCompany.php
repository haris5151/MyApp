<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CdCompany extends Model
{
    use HasFactory;
    protected $fillable = [
    'name',
    'location',
    'address',
    'is_active',
    'description',
    'created_by',
    'updated_by',
    ];
    public function cd_branches()
    {
        return $this->hasMany(CdBranch::class, 'cd_company_id');
    }
    public function md_products()
    {
        return $this->hasMany(MdProduct::class, 'cd_company_id');
    }
    public function td_orders()
    {
        return $this->hasMany(TdOrder::class, 'cd_company_id');
    }
    public function td_order_details()
    {
        return $this->hasMany(TdOrderDetail::class, 'cd_company_id');
    }
    public function td_purchases()
    {
        return $this->hasMany(TdPurchase::class, 'cd_company_id');
    }
    public function td_purchase_details()
    {
        return $this->hasMany(TdPurchaseDetail::class, 'cd_company_id');
    }
    public function td_receipts()
    {
        return $this->hasMany(TdReceipt::class, 'cd_company_id');
    }
    public function md_services()
    {
        return $this->hasMany(MdService::class, 'cd_company_id');
    }
}
