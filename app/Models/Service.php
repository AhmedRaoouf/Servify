<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'id', 'status', 'image',
    ];

    public function description($language_id = null)
    {
        $language_id = $language_id ?: currentLanguage()->id;
        return $this->hasMany(ServiceDescription::class)->where('language_id', $language_id)->first();
    }

    public function withDescription($service_id = null)
    {
        $language_id = currentLanguage()->id;

        $query = self::join('service_descriptions AS sd', 'sd.service_id', '=', 'services.id')
            ->where('sd.language_id', $language_id)
            ->select('services.id', 'services.status', 'services.image', 'sd.name', 'sd.description');

        if ($service_id !== null) {
            $query->whereIn('services.id', (array) $service_id);
        }

        return $query;
    }


    public function users()
    {
        return $this->belongsToMany(User::class, 'user_services');
    }
}
