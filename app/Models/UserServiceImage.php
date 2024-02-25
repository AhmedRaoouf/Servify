<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserServiceImage extends Model
{
    use SoftDeletes;
    protected $table = 'user_service_images';
    protected $fillable = [
        'image',
        'user_id',
        'service_id',
    ];
}
