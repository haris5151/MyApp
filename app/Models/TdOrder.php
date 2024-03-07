<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TdOrder extends Model
{
    use HasFactory;
    protected $fillable = [
        'cd_company_id',
        'cd_branch_id',
        'is_active',
        'description',
        'created_by',
        'updated_by',
    ];
    public function td_order_details()
    {
        return $this->hasMany(TdOrderDetail::class, 'td_order_id');
    }
    public function td_receipts()
    {
        return $this->hasMany(TdReceipt::class, 'td_order_id');
    }
    public function cd_staff()
    {
        return $this->hasMany(CdStaff::class, 'td_order_id');
    }
    public function cd_companies()
    {
        return $this->belongsTo(CdCompany::class, 'cd_company_id');
    }
    public function cd_branches()
    {
        return $this->belongsTo(CdBranch::class, 'cd_branch_id');
    }
}
