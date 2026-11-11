<?php

use App\Http\Controllers\Web\Backend\Blog\BlogController;
use App\Http\Controllers\Web\Backend\DashboardController;
use App\Http\Controllers\Web\Backend\ExchangeRate\CurrencyController;
use App\Http\Controllers\Web\Backend\ExchangeRate\ExchangeRateController;
use App\Http\Controllers\Web\Backend\ExchangeRate\ExchangeTypeController;
use App\Http\Controllers\Web\Backend\ExchangeRate\ProviderController;
use App\Http\Controllers\Web\Backend\JobPost\JobPostController;
use App\Http\Controllers\Web\Backend\Settings\CustomScriptController;
use App\Http\Controllers\Web\Backend\Settings\DynamicPageController;
use App\Http\Controllers\Web\Backend\Settings\MailSettingController;
use App\Http\Controllers\Web\Backend\Settings\ProfileController;
use App\Http\Controllers\Web\Backend\Settings\StripeSettingController;
use App\Http\Controllers\Web\Backend\Settings\SystemSettingController;
use App\Http\Controllers\Web\Backend\User\UserController;
use Illuminate\Support\Facades\Route;


Route::middleware('auth')->group(function () {


    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');


    //Route for SystemSettingController
    Route::get('/system-setting', [SystemSettingController::class, 'index'])->name('settings.system.index');
    Route::post('/system-setting/', [SystemSettingController::class, 'update'])->name('settings.system.update');

    //Route for ProfileController
    Route::get('/profile', [ProfileController::class, 'showProfile'])->name('settings.profile');
    Route::post('/update-profile', [ProfileController::class, 'updateProfile'])->name('settings.update-profile');
    Route::post('/update-profile-password', [ProfileController::class, 'updatePassword'])->name('settings.update-password');

    //Route for MailSettingController
    Route::get('/mail-setting', [MailSettingController::class, 'index'])->name('settings.mail');
    Route::post('/mail-setting', [MailSettingController::class, 'update'])->name('settings.mail-update');


});
