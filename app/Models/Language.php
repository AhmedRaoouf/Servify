<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Language extends Model
{
    use SoftDeletes;
    protected $fillable = ['local','name'];

    public function country_descriptions()
    {
        return $this->hasMany(CountryDescription::class, 'language_id');
    }
    public function governorate_descriptions()
    {
        return $this->hasMany(GovernorateDescription::class, 'language_id');
    }

    public function service_descriptions()
    {
        return $this->hasMany(ServiceDescrition::class,'language_id');
    }
}
