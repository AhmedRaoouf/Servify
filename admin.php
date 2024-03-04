<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\HomeController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::get("login", [AuthController::class,"loginform"])->name("login")->middleware('guest');
Route::post("login",[AuthController::class,"login"])->middleware('guest')->name('admin.login');
// Route::group(["prefix" => LaravelLocalization::setLocale()], function () {
//     Route::middleware(['auth','enter-dashboard'])->group(function () {
//         Route::get("/logout",[AuthController::class,'logout'])->name('logout');
//         Route::get("/home",[HomeController::class,"index"]);
//         Route::resource('admins', AdminController::class);
//     });

// });

Route::middleware(['auth','enter-dashboard'])->group(function () {
    Route::get("/logout",[AuthController::class,'logout'])->name('logout');
    Route::get("/home",[HomeController::class,"index"]);
    Route::resource('admins', AdminController::class);
});
