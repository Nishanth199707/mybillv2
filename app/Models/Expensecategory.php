<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expensecategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'user_id',
        'status',
        'description',
        'updated_at',
        'created_at'

    ];
}
