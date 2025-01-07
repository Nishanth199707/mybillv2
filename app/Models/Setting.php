<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'business_id',
        'user_id',
        'ewaybill_no',
        'purchase_order_date',
        'purchase_order_number',
        'vehicle_no',
        'logo',
        'emi',
        'description',
        'signature',
        'shipping_address',
        'invoice',
        'watermark',
    ];
    public function details()
    {
        return $this->hasMany(SettingDetail::class, 'settings_id');
    }
}
