<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseCustomDetails extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'business_id',
        'party_id',
        'purchase_id',
        'product_id',
        'field_name',
        'field_value',
        'stock',
    ];
    
}
