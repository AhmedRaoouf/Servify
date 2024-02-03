<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceFeatureDescription extends Model
{
    use HasFactory;
    protected $fillable = ['id','language_id','service_feature_id'];

}
