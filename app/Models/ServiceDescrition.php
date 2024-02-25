<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceDescrition extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'service_id',
        'language_id',
    ];

}
