<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\LocalizationController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::group(["prefix" => LaravelLocalization::setLocale()], function () {
    Route::group(['prefix' => 'dashboard'], function () {

        Route::get("login", [AuthController::class, "loginform"])->name("admin.login")->middleware('guest');
        Route::post("login", [AuthController::class, "login"]);
        Route::middleware(['admin-auth', 'enter-dashboard'])->group(function () {
            Route::get("/logout", [AuthController::class, 'logout'])->name('logout');
            Route::get('/change-language/{locale}', [LocalizationController::class,'changeLanguage'])->name('change.language');

            Route::get("/home", [HomeController::class, "index"]);
            Route::resource('admins', AdminController::class)->except(["show"]);
            Route::resource('services', ServiceController::class)->except(["show"]);
        });
    });
});
