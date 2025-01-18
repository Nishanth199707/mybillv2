<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'business_id',
        'image',
        'item_type',
        'category',
        'sub_category_id',
        'item_code_barcode',
        'item_name',
        'price_type',
        'sale_price',
        'gst_rate',
        'units',
        'stock',
        'purchase_type',
        'purchase_price',
        'hsn_code',
        'description',
        'imei',
        'status',
    ];
}
