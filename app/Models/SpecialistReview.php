<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpecialistReview extends Model
{
    use HasFactory;

    protected $table = 'specialist_reviews';
    protected $fillable = [
        'user_id',
        'specialist_id',
        'rating',
        'comment',
    ];
    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
}
