<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAuthentication extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'token',
        'otp',
        'verification_code',
        'verification_code_created_at',
        'facebook_id',
        'google_id',
        'email_verified_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
}
