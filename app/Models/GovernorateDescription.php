<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GovernorateDescription extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'governorate_id',
        'country_id',
        'language_id'
    ];
}
