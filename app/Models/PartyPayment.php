<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartyPayment extends Model
{
    use HasFactory;


    protected $fillable = [
        'user_id',
        'business_id',
        'party_id',
        'transaction_type',
        'invoice_no',
        'remark',
        'paid_date',
        'credit',
        'debit',
        'payment_type',
        'mode_of_payment',
        'receipt_type',
        'transaction_number',
        'collection_date',
        'opening_balance',
        'closing_balance',
    ];

}
