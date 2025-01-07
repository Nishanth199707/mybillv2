<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleReturnDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'business_id',
        'user_id',
        'party_id',
        'sale_return_id',
        'product_id',
        'item_description',
        'rpqty',
        'qty',
        'amount',
        'gst',
        'gstvaldata',
        'total_amount',
        'created_at',
        'updated_at',

       ];
}
