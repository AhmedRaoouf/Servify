<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CountryDescription extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'country_id',
        'language_id'
    ];

    

}
