<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Emi extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'business_id',
        'sale_id',
        'financier_name',
        'loan_no',
        'initial_payment',
        'emi',
        'scheme',
    ];
}
