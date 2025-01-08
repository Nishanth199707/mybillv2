<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'logo',
        'company_name',
        'gstavailable',
        'gstin',
        'phone_no',
        'email',
        'address',
        'business_type',
        'business_category',
        'pincode',
        'state',
        'city',
        'country',
        'description',
        'signature',
        'gst_auth',
        'auth_response',
    ];
}
