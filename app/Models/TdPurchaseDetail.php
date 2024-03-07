<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TdPurchaseDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'td_purchase_id',
        'cd_company_id',
        'cd_branch_id',
        'is_active',
        'description',
        'created_by',
        'updated_by',
    ];
    public function md_expenses()
    {
        return $this->hasMany(MdExpense::class, 'td_purchase_detail_id');
    }
    public function cd_companies()
    {
        return $this->belongsTo(CdCompany::class, 'cd_company_id');
    }
    public function cd_branches()
    {
        return $this->belongsTo(CdBranch::class, 'cd_branch_id');
    }
    public function td_purchases()
    {
        return $this->belongsTo(TdPurchase::class, 'td_purchase_id');
    }
}
