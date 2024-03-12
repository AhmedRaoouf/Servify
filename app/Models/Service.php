<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'id','status','image',
    ];
    public function serviceDescription()
    {
        return $this->hasMany(ServiceDescription::class,'service_id');
    }
    public function description($language_id = null)
    {
        $language_id = $language_id ?: currentLanguage()->id;
        return $this->hasMany(ServiceDescription::class)->where('language_id', $language_id)->first();
    }

    public function withDescription($service_id=null)
    {
        $language_id = currentLanguage()->id;

        $query = self::join('service_descriptions As sd','sd.service_id','services.id')
        ->where('sd.language_id',$language_id)
        ->select('services.*','sd.name');

        if ($service_id) {
            $query->whereIn( 'services.id' ,$service_id);
        }
        return  $query;
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_services');
    }
}
