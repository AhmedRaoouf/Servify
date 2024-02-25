<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'image',
        'role_id',
        'gender',
        'country_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function modules()
    {
        return $this->belongsToMany(Module::class, 'user_modules');
    }

    public function hasModule($module)
    {
        return $this->modules->contains('path', $module);
    }

    public function canAccess($module)
    {
        return $this->role->name == 'admin' ? true : $this->hasModule($module);
    }

    public function auth()
    {
        return $this->hasOne(UserAuthentication::class);
    }

    public function location()
    {
        return $this->hasOne(UserLocation::class);
    }

    public function governorate()
    {
        return $this->belongsTo(Governorate::class);
    }
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function services()
    {
        return $this->belongsToMany(Service::class, 'user_services');
    }
}
