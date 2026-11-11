<?php

use App\Http\Controllers\API\Ai\ApiAiAnalysisController;
use App\Http\Controllers\API\Auth\AuthController;
use App\Http\Controllers\API\Auth\ResetPasswordController;
use App\Http\Controllers\API\BlogController;
use App\Http\Controllers\API\ProfileController;
use App\Http\Controllers\API\SocialLogin\ApiSocialLoginController;
use App\Http\Controllers\CableSizeController;
use App\Http\Controllers\ReferenceController;
use App\Http\Controllers\VoltDropController;
use Illuminate\Support\Facades\Route;

//Route for Auth Controller

Route::post('/register', [AuthController::class, 'register']);
Route::post('/register-seller', [AuthController::class, 'registerSeller']);
Route::post('/verify/registration', [AuthController::class, 'verifyRegistrationOtp']);
Route::post('/resend/registration/otp', [AuthController::class, 'resendRegistrationOtp']);
Route::post('/complete-register', [AuthController::class, 'completeRegistration']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/verify-email', [AuthController::class, 'manualEmailVerify']);
Route::post('/logout', [AuthController::class, 'logout']);
Route::post('refresh', [AuthController::class, 'refresh']);



Route::post('/verify-otp', [AuthController::class, 'verifyOtp']);


//Route for ResetPasswordController
Route::post('forgot-password', [ResetPasswordController::class, 'forgotPassword']);
Route::post('verify-otp', [ResetPasswordController::class, 'verifyOtp']);
Route::post('reset-password', [ResetPasswordController::class, 'resetPassword']);


// Public blog routes
Route::get('/blogs', [BlogController::class, 'index']);
Route::get('/blogs/{slug}', [BlogController::class, 'show']);


// --------------Volt Drop Module--------------
Route::get('/volt-drop/index', [VoltDropController::class, 'index'])->name('volt_drop_index');
Route::post('/volt-drop/calculate', [VoltDropController::class, 'voltdropCalculate'])->name('volt_drop_calculate');

// --------------cable Size Module--------------
Route::post('/cable-size/calculate', [CableSizeController::class, 'cableSizeCalculate'])->name('cable_size_calculate');

Route::post('/social-login', [ApiSocialLoginController::class, 'SocialLogin']);

// --------------Reference ASNZS-3000 Module--------------
Route::middleware('auth:api')->group(function () {
    Route::get('/asnzs_reference/index', [ReferenceController::class, 'index'])->name('asnzs_reference.index')->middleware('auth:api');
    Route::get('/asnzs_reference/index/search', [ReferenceController::class, 'api_search'])->name('asnzs_reference.index.api.search')->middleware('auth:api');
    Route::get('/asnzs_reference/show/{id}', [ReferenceController::class, 'show'])->name('asnzs_reference.show')->middleware('auth:api');
});



// --------------User Profile API--------------
Route::middleware('auth:api')->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('api.profile.index');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('api.profile.update');

     Route::post('/profile/verify-email-change', [ProfileController::class, 'verifyEmailChange'])->name('api.profile.verifyEmailChange');
    Route::post('/profile/resend-email-change-otp', [ProfileController::class, 'resendEmailChangeOtp'])->name('api.profile.resendEmailChangeOtp');

    Route::post('/profile/user-delete', [ProfileController::class, 'userDelete'])->name('api.profile.user_delete');
});
// --------------User Profile API--------------

// --------------About+Help API--------------
Route::get('/profile/help_about', [ProfileController::class, 'apiHelpAbout'])->name('api_management_help_about');
// --------------About+Help API--------------





Route::post('/analyze-electric', [ApiAiAnalysisController::class, 'chatWithSession']);






















































































































































































































