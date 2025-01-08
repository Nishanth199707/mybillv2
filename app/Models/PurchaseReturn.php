<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseReturn extends Model
{
    use HasFactory;
    protected $fillable = [
        'party',
        'business_id',
        'user_id',
        'party_id',
        'purchase_date',
        'purchase_no',
        'totalAmountDisplay',
        'taxable28Amount',
        'taxable18Amount',
        'taxable12Amount',
        'taxable5Amount',
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
        'bill_type',
        'created_at',
        'updated_at',
        'remarks',
    ];

    public function details()
    {
        return $this->hasMany(PurchaseReturnDetail::class, 'purchase_return_id');
    }

}
