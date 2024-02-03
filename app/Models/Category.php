<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = ['id'];

    public function descriptions($language_id = null)
    {
        if ($language_id) {
            $data = $this->hasMany(CategoryDescription::class)->where('language_id', $language_id)->first();
            if (!$data) {
                $data = $this->hasMany(CategoryDescription::class)->first();
            }
            return $data;
        }
        $data = $this->hasMany(CategoryDescription::class)->where('language_id', currentLanguage()->id)->first();
        return $data;
    }
    public static function withDescription($category_id = null)
    {
        $query = self::join('category_descriptions AS cd', 'cd.category_id', 'categories.id')
            ->where('cd.language_id', currentLanguage()->id)
            ->select(['categories.created_at', 'cd.*']);

        if ($category_id) {
            if (is_array($category_id)) {
                $query->whereIn('categories.id', $category_id);
            } else {
                $query->where('categories.id', $category_id);
            }
        }
        $query->select([
            'categories.*',
            'cd.title',

        ]);
        return $query;
    }
}
