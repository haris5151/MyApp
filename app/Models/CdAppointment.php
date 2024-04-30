<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CdAppointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'receiver_id',
        'service_detail_id',
        'status',
        'description',
        'appointment_date',
        'appointment_time',
        'created_by',
        'updated_by',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function serviceDetail()
    {
        return $this->belongsTo(MdServiceDetail::class,  'created_by');
    }
    public function service()
    {
        return $this->belongsTo(MdServiceDetail::class, 'id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}
