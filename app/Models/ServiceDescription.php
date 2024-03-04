<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceDescription extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'image',
        'service_id',
        'language_id',
    ];

    public function  service() {
        return $this->belongsTo(Service::class);
    }
}
