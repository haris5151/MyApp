<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MdProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'cd_company_id',
        'cd_branch_id',
        'name',
        'price',
        'image',
        'is_active',
        'description',
        'created_by',
        'updated_by',
    ];
    public function cd_companies()
    {
        return $this->belongsTo(CdCompany::class, 'cd_company_id');
    }
    public function cd_branches()
    {
        return $this->belongsTo(CdBranch::class, 'cd_branch_id');
    }
}
