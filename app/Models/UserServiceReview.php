<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserServiceReview extends Model
{
    use SoftDeletes;
    protected $table = 'user_service_reviews';
    protected $fillable = [
        'rating',
        'comment',
        'user_id',
        'service_id',
    ];

}
