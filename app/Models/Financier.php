<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Financier extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'business_id',
        'financier_name',
        'agent_code',
        'executive_name',
        'executive_phone',
        'company_email',
    ];
}
