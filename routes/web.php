<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\API\StripePaymentController;
use App\Http\Controllers\ReferenceController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\Web\Frontend\HomeController;
use App\Http\Controllers\Web\Frontend\FooterController;
use App\Http\Controllers\Web\Frontend\BlogController;


//live command run
Route::get('/run-migrate', function () {
    Artisan::call('migrate');
    return 'Database migration completed successfully!';
});

Route::get('/run-fresh-migrate-seed', function () {
    try {
        Artisan::call('migrate:fresh --seed');
        return 'Database refreshed and seeded successfully!';
    } catch (\Exception $e) {
        return 'Error: ' . $e->getMessage();
    }
});

Route::get('/optimize-clear', function () {
    try {
        Artisan::call('optimize:clear');
        return 'Application cache cleared successfully!';
    } catch (\Exception $e) {
        return 'Error: ' . $e->getMessage();
    }
});

// added by Tanvir
Route::get('/', function () {
    return redirect()->route('login');
});

// --------------- Admin Dashboard:Modules ------------------
Route::middleware('auth:web')->group(function () {
    Route::get('/admin/volt-drop/index', [AdminDashboardController::class, 'index'])->name('admin.voltdrop.index');
    Route::get('/admin/cable-size/index', [AdminDashboardController::class, 'index'])->name('admin.cablesize.index');
    Route::get('/admin/reference/index', [AdminDashboardController::class, 'index'])->name('admin.reference.index');
    Route::get('/admin/ai-chat/index', [AdminDashboardController::class, 'index'])->name('admin.aichat.index');
});
// --------------- Admin Dashboard:Modules ------------------

// --------------- Admin > Modules:Reference ------------------
Route::middleware('auth:web')->group(function () {
    Route::get('/reference/create', [ReferenceController::class, 'create'])->name('reference.create');
    Route::post('/reference/store', [ReferenceController::class, 'store'])->name('reference.store');

    Route::get('/admin/reference/category/{refCategory}/edit', [ReferenceController::class, 'editCategory'])->name('reference.category.edit');
    Route::post('/admin/reference/category/{refCategory}/update', [ReferenceController::class, 'updateCategory'])->name('reference.category.update');

    Route::get('/admin/reference/content/{refContent}/edit', [ReferenceController::class, 'editContent'])->name('reference.content.edit');
    Route::post('/admin/reference/content/{refContent}/update', [ReferenceController::class, 'updateContent'])->name('reference.content.update');

    Route::post('/admin/reference/category/{refCategory}/delete', [ReferenceController::class, 'deleteCategory'])->name('reference.category.delete');
    Route::get('/admin/reference/index/search', [ReferenceController::class, 'search'])->name('admin.reference.search');

    Route::post('/admin/reference/{refContent}/delete', [ReferenceController::class, 'deleteContent'])->name('reference.content.delete');
});
// --------------- Admin > Modules:Reference ------------------

// --------------- Admin > Management ------------------
Route::middleware('auth:web')->group(function () {
    Route::get('/manage/users', [AdminDashboardController::class, 'allUsers'])->name('manage.users');
    Route::post('all-users/table', [AdminDashboardController::class, 'all_users_data'])
     ->name('backend.dataTable_all_users');
    Route::post('all-users/table/user/{id}/block', [AdminDashboardController::class, 'userBlock'])->name('backend.user_block');
    Route::post('all-users/table/user/{id}/delete', [AdminDashboardController::class, 'userDelete'])->name('backend.user_delete');
     

    Route::get('/manage/about_help', [AdminDashboardController::class, 'aboutHelpIndex'])->name('manage.about_help');
    Route::post('/manage/about/store', [AdminDashboardController::class, 'helpAboutStore'])->name('manage.help_about_store');
    Route::post('/manage/about/delete', [AdminDashboardController::class, 'aboutDelete'])->name('manage.about_delete');

    Route::get('/manage/this/profile', [AdminDashboardController::class, 'thisAdminProfile'])->name('manage.this_profile');
    Route::post('/manage/this/profile/{id}/update', [AdminDashboardController::class, 'thisAdminProfileUpdate'])->name('manage.this_profile_update');
    
});
// --------------- Admin > Management ------------------

Route::get('/about-us', [AdminDashboardController::class, 'publicDisplayAbout'])->name('public_display_about');
Route::get('/terms-and-conditions', [AdminDashboardController::class, 'publicDisplayTerms'])->name('public_display_terms');
Route::get('/privacy-policy', [AdminDashboardController::class, 'publicDisplayPrivacy'])->name('public_display_privacy');





require __DIR__ . '/auth.php';
