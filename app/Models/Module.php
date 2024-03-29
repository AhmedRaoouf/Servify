<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Module extends Model
{
    use SoftDeletes;
    protected $fillable = ['name', 'path'];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
