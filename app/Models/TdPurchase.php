<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TdPurchase extends Model
{
    use HasFactory;
    protected $fillable = [
        'cd_company_id',
        'cd_branch_id',
        'is_active',
        'description',
        'date_transaction',
        'created_by',
        'updated_by',
       
    ];
    public function td_purchase_details()
    {
        return $this->hasMany(TdPurchaseDetail::class, 'td_purchase_id');
    }
    public function md_expenses()
    {
        return $this->hasMany(MdExpense::class, 'td_purchase_id');
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
