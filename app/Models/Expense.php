<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'expense_ref',
        'user_id',
        'dateofexpense',
        'amount',
        'cash_type',
        'updated_at',
        'created_at'

    ];
}

