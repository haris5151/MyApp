<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TdOrderDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'td_order_id',
        'cd_company_id',
        'cd_branch_id',
        'is_active',
        'description',
        'created_by',
        'updated_by',
    ];
    public function cd_staff()
    {
        return $this->hasMany(CdStaff::class, 'td_order_detail_id');
    }
    public function cd_companies()
    {
        return $this->belongsTo(CdCompany::class, 'cd_company_id');
    }
    public function cd_branches()
    {
        return $this->belongsTo(CdBranch::class, 'cd_branch_id');
    }
    public function td_orders()
    {
        return $this->belongsTo(TdOrder::class, 'td_order_id');
    }
}
