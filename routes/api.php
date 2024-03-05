<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ForgetController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Authentication
Route::middleware(['lang'])->group(function (){

    Route::post("/register", [AuthController::class, "register"]);
    Route::post("/login", [AuthController::class, "login"]);
    Route::get('login/google/callback/{uid}', [AuthController::class, "handleGoogleLogin"]);
    Route::get('login/facebook/callback/{uid}', [AuthController::class, "handleFacebookLogin"]);

    Route::post('/send-verification-code', [AuthController::class, 'sendVerificationCode']);
    Route::post('/verify-email/{code}', [AuthController::class, 'verify']);

    // Forget & Reset Password
    Route::post('/forget', [ForgetController::class, 'forget']);
    Route::post('/otp/{otp}', [ForgetController::class, 'otp']);
    Route::post('/reset/{otp}', [ForgetController::class, 'reset']);

    Route::middleware(['api_auth','api_authVerify'])->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        // Users
        Route::post('user/image/update', [UserController::class, 'uploadImage']);
        //profile
        Route::get('/profile', [ProfileController::class, 'show']);
        Route::patch('/profile/update', [ProfileController::class, 'update']);
    });
});
