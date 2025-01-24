<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleReturn extends Model
{
    use HasFactory;
    protected $fillable = [
        'party',
        'business_id',
        'user_id',
        'party_id',
        'return_invoice_date',
        'return_invoice_no',
        'totalAmountDisplay',
        'taxable28Amount',
        'taxable18Amount',
        'taxable12Amount',
        'taxable5Amount',
        'taxable0Amount',
        'tax_amount_28_cgst',
        'tax_amount_28_sgst',
        'tax_amount_18_cgst',
        'tax_amount_18_sgst',
        'tax_amount_12_cgst',
        'tax_amount_12_sgst',
        'tax_amount_5_cgst',
        'tax_amount_5_sgst',
        'tax_amount',
        'net_amount',
        'totQues',
        'cash_type',
        'bill_type',
        'created_at',
        'updated_at',
       ];
}
