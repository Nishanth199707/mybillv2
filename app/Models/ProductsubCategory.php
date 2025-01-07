<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductsubCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'business_id',
        'product_categories_id',
        'name',
        'description',
        'status',
    ];
}
