<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Specialist extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'service_id',
        'average_rating',
        'description',
        'num_of_experience',
        'num_of_customers',
        'earning',
        'personal_card',
        'personal_image',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

}
