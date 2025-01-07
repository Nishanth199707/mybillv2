<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    //

    protected $fillable = [
        'plan_id',
        'user_id',
        'amount',
        'transaction_id',
        'payment_status',
        'response_msg',
        'providerReferenceId',
        'merchantOrderId',
        'checksum'
    ];

    public function plan()
    {
        return $this->belongsTo(Plan::class, 'plan_id');
    }
}
