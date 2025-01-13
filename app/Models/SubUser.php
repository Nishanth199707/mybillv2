<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'password',
        'permissions',
    ];

    protected $casts = [
        'permissions' => 'array', 
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function parentUser()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
