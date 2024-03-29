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
}
