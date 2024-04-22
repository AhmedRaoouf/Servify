<?php

use App\Models\Language;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

if (!function_exists('currentLanguage')) {
    /**
     * Return Current Language from datebase
     * @return mixed
     */
    function currentLanguage():mixed
    {
        $language = Language::where('local', LaravelLocalization::getCurrentLocale())->first();
        return $language;
    }
}
if (!function_exists('getCurrentLocale')) {
    /**
     * Return Current Local from datebase
     * @return mixed
     */
    function getCurrentLocale()
    {
        $current = Language::where('local', LaravelLocalization::getCurrentLocale())->first()->local;
        return $current;
    }
}
if (!function_exists('languages')) {
    /**
     * Return List of Languages from datebase
     * @return mixed
     */
    function languages()
    {
        $languages = Language::cursor();
        return $languages;
    }
}
