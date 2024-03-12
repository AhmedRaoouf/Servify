<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Redirect;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class LocalizationController extends Controller
{
    public function changeLanguage($locale)
    {
        LaravelLocalization::setLocale($locale);
        $url = LaravelLocalization::getLocalizedURL($locale, Redirect::back()->getTargetUrl());
        return Redirect::to($url);
    }
}
