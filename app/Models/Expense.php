<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'user_id',
        'expense_ref',
        'exp_type',
        'dateofexpense',
        'amount',
        'cash_type',
        'description',
        'updated_at',
        'created_at'

    ];
}

