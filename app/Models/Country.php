<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Country extends Model
{
    use SoftDeletes;
    protected $fillable = ['id'];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function  governoratesDescription($country_id=null,$language_id = null)
    {
        $language_id = $language_id ?: currentLanguage()->id;
        return $this->hasMany(GovernorateDescription::class)
        ->where('language_id', $language_id)
        ->where('country_id',$country_id)
        ->select('name','governorate_id')
        ->get();
    }

    public function description($language_id = null)
    {
        $language_id = $language_id ?: currentLanguage()->id;
        return $this->hasMany(CountryDescription::class)
        ->where('language_id', $language_id)
        ->select('name','country_id')
        ->first();
    }

}
