<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expensedetails extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'expense_id',
        'expensecategory_id',
        'expense_name',
        'price',
        'description',
        'updated_at',
        'created_at'

    ];
}
