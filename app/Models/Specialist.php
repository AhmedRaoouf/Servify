<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Specialist extends Model
{
    use HasFactory;
    protected $fillable = [
        'average_rating',
        'user_id',
        'service_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
