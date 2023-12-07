<?php

use App\Http\Controllers\Api\AuthController;
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

Route::post("/register", [AuthController::class, "register"]);
Route::post("/login",[AuthController::class, "login"])->name('login');

Route::post('/forget',[AuthController::class,'forget']);
Route::post('/otp/{otp}',[AuthController::class,'otp']);
Route::post('/reset/{otp}',[AuthController::class,'reset']);

Route::middleware(['api_auth'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::post('/send-verification-code', [AuthController::class,'sendVerificationCode']);
Route::post('/verify-email/{code}', [AuthController::class,'verify']);


