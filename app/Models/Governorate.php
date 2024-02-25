<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Governorate extends Model
{
    use HasFactory;
    protected $fillable = ['id'];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function description($language_id = null)
    {
        $language_id = $language_id ?: currentLanguage()->id;
        return $this->hasMany(GovernorateDescription::class)->where('language_id', $language_id)->first();
    }

    public function withDescription($governorate_id=null)
    {
        $language_id = currentLanguage()->id;
        $query = self::join('governorate_descriptions As cd','cd.governorate_id','governorates.id')
        ->where('cd.language_id',$language_id)
        ->select('governorates.*','cd.name');

        if ($governorate_id) {
            $query->whereIn( 'governorates.id' ,$governorate_id);
        }
        return  $query;
    }
}
