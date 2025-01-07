<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{
    protected $fillable = [
   'party',
        'business_id',
        'user_id',
        'party_id',
        'quotation_date',
        'quotation_no',
        'discount',
        'taxable28Amount',
        'taxable18Amount',
        'taxable12Amount',
        'taxable5Amount',
        'totalAmountDisplay',
        'tax_amount_28_cgst',
        'tax_amount_28_sgst',
        'tax_amount_18_cgst',
        'tax_amount_18_sgst',
        'tax_amount_12_cgst',
        'tax_amount_12_sgst',
        'tax_amount_5_cgst',
        'tax_amount_5_sgst',
        'tax_amount_28_igst',
        'tax_amount_18_igst',
        'tax_amount_12_igst',
        'tax_amount_5_igst',
        'tax_amount',
        'net_amount',
        'totQues',
        'cash_type',
        'quotation_details',
    ];

    // Define relationships if necessary
    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    public function party()
    {
        return $this->belongsTo(Party::class);
    }
}
