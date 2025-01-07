<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Repair extends Model
{
    use HasFactory;

    protected $fillable = [
        'business_id',
        'user_id',
        'service_no',
        'customer_name',
        'address',
        'phone',
        'date',
        'complaint_remark',
        'imei',
        'mobile_pin',
        'phone_condition',
        'battery',
        'battery_details',
        'sim',
        'sim_details',
        'estimated_amount',
        'estimated_delivery_date',
        'received_by',
        'model',
        'cash_received',
        'status',
    ];
}
