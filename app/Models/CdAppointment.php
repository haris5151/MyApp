<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CdAppointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'service_id',
        'status',
        'description',
        'appointment_date',
        'appointment_time',
    ];

    public function service()
    {
        return $this->belongsTo(User::class, 'service_id');
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }
}
