<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditAccess extends Model
{
    use HasFactory;

    protected $fillable = [
        'auditor_id',
        'target_user_id',
        'user_id',
        'status',
        'reason',
    ];

  
    public function auditor()
    {
        return $this->belongsTo(User::class, 'auditor_id');
    }


    public function targetUser()
    {
        return $this->belongsTo(User::class, 'target_user_id');
    }



}
