<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskManager extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'user_id',
        'business_id',
        'party',
        'product',
        'description',
        'status',
        'sub_user',
    ];
}
