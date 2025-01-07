<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class SettingDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'business_id',
        'user_id',
        'settings_id',
        'vehicle_no',
        'logo_image',
        'logo_text',
        'description_image',
        'description_text',
        'signature_image',
    ];
}
