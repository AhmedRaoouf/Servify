<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\Api\ForgetController;
use App\Http\Controllers\Api\LocationController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\SpecialistController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\JsonResponse;
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
Route::middleware(['lang'])->group(function () {

    Route::post("/register", [AuthController::class, "register"]);
    Route::post("/login", [AuthController::class, "login"]);
    //Login with provider like facebook or google
    Route::post('login/{provider}/callback/{uid}', [AuthController::class, "handleSocialLogin"]);

    Route::post('/send-verification-code', [AuthController::class, 'sendVerificationCode']);
    Route::post('/verify-email/{code}', [AuthController::class, 'verify']);

    // Forget & Reset Password
    Route::post('/forget', [ForgetController::class, 'forget']);
    Route::post('/otp/{otp}', [ForgetController::class, 'otp']);
    Route::post('/reset/{otp}', [ForgetController::class, 'reset']);

    //location
    Route::get('/countries', [LocationController::class, 'getCountries']);
    Route::get('/county/{country}/governorate', [LocationController::class, 'getGovernorates']);

    //Services
    Route::get('services', [ServiceController::class, "index"]);
    Route::get('services/best-specialists', [ServiceController::class, 'fetchBestSpecialists']);
    Route::get('services/filter-specialists', [ServiceController::class, 'filterSpecialists']);
    Route::get('services/{service}',[ServiceController::class,'showAll']);

    Route::middleware(['api_auth', 'api_authVerify'])->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        // Users
        Route::post('user/image/update', [UserController::class, 'uploadImage']);
        Route::post('user/password/update', [UserController::class, 'updatePassword']);
        //profile
        Route::get('/profile', [ProfileController::class, 'show']);
        Route::patch('/profile/update', [ProfileController::class, 'update']);
        //Services

        //Specialists
        Route::apiResource('specialist', SpecialistController::class);
        Route::post('specialist/{specialist}/rating', [SpecialistController::class, 'rating']);

        // Booking
        Route::apiResource('bookings',BookingController::class);
        Route::get('bookings/status/{status}', [BookingController::class, 'status']);

    });
});
