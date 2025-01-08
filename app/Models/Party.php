<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Party extends Model
{
    use HasFactory;
    protected $fillable = [
            'user_id',
            'business_id',
            'transaction_type',
            'party_type',
            'state',
            'name',
            'gstin',
            'phone_no',
            'email',
            'billing_address_1',
            'billing_address_2',
            'billing_pincode',
            'shipping_address_1',
            'shipping_address_2',
            'shipping_pincode',
            'opening_balance',
            'gst_profile',
            'gst_response',
    ];
}
